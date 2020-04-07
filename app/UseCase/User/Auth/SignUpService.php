<?php

namespace App\UseCase\User\Auth;

use App\Entity\Location\District;
use App\Entity\User\User;
use App\Events\User\Verification\EmailConfirmed;
use App\Events\User\Verification\PhoneConfirmed;
use App\Service\Sms\SmsSenderInterface;
use App\Service\User\ConfirmCode\CodeGeneratorInterface;
use Carbon\Carbon;
use Illuminate\Contracts\Mail\Mailer;
use Illuminate\Http\Request;
use Illuminate\Session\Store;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class SignUpService
{
    const SESSION_EMAIL_CODE_KEY = 'email_code';
    const SESSION_EMAIL_KEY = 'email';

    const SESSION_PHONE_KEY = 'phone';
    const SESSION_PHONE_CODE_KEY = 'phone_code';

    /**
     * @var SessionInterface
     */
    private $session;
    /**
     * @var CodeGeneratorInterface
     */
    private $codeGenerator;
    /**
     * @var Mailer
     */
    private $mailer;
    /**
     * @var SmsSenderInterface
     */
    private $smsSender;

    public function __construct(Store $session, CodeGeneratorInterface $codeGenerator, Mailer $mailer, SmsSenderInterface $smsSender)
    {
        $this->session = $session;
        $this->codeGenerator = $codeGenerator;
        $this->mailer = $mailer;
        $this->smsSender = $smsSender;
    }

    public function save(User $user, Request $request)
    {
        $user->update([
            'birth_date' => $request->birth_date,
            'city_id' => $request->city,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'password' => Hash::make($request->password),
            'sex' => $request->sex,
            'about' => $request->about,
        ]);

        if($user->isCustomer()) {
            $user->activate(Carbon::now());
        }
    }

    public function updateWorkData(User $user, Request $request)
    {
        if($user->isCustomer()) {
            throw new \DomainException('Рабочие данные могут указывать только исполнители.');
        }

        $data = [
            'legal_type' => $request->legal_type,
            'team_type' => $request->team_type,
            'brigade_size' => $request->brigade_size,
            'about' => $request->about,
            'main_city_id' => $request->city_id,
            'company_name' => $request->company_name,
        ];

        if(!$user->workData) {
            $user->workData()->create($data);

            return;
        }

        $user->workData()->update($data);

        $data = [];
        foreach (array_unique($request->get('districts')) as $districtId) {
            $data[$districtId] = ['entity_id' => $user->id, 'type' => District::TYPE_USER];
        }
        $user->workData->districts()->attach($data);
    }

    public function updateWorkCategories(User $user, Request $request)
    {
        if($user->isCustomer()) {
            throw new \DomainException('Категории работы могут указывать только исполнители.');
        }

        $user->workData->categories()->detach();

        $categories = array_unique($request->get('categories'));
        if(count($categories) > 2 && !$user->hasPremium()) {
            throw new \DomainException('Только премиум пользователь может иметь больше 2-х категорий в специализации.');
        }

        $data = [];
        foreach ($categories as $categoryId) {
            $price = $request->get('prices', [])[$categoryId] ?? null;

            $data[$categoryId] = ['user_id' => $user->id, 'price' => $price];
        }
        $user->workData->categories()->attach($data);
    }

    public function getLastEmail(): string
    {
        if(empty($email = $this->session->get(self::SESSION_EMAIL_KEY))) {
            throw new \DomainException('Ошибка получения последней введеной почты.');
        }

        return $email;
    }

    public function sendEmailConfirmCode(User $user): void
    {
        if(empty($user->email)) {
            throw new \InvalidArgumentException('Почта не заполнена.');
        }

        $user->update(['verification_email_code' => $code = $this->codeGenerator->generate()]);
        $user->sendEmailVerificationNotification();
    }

    public function confirmEmail(User $user)
    {
        $user->confirmEmail($date = Carbon::now());
        event(new EmailConfirmed($user));
    }

    public function confirmPhone(User $user)
    {
        $user->confirmPhone($date = Carbon::now());
        event(new PhoneConfirmed($user));
    }

    public function checkEmailConfirmCode(int $code, User $user): void
    {
        if($user->verification_email_code !== $code) {
            throw new \DomainException('Проверочный код не верный.');
        }
    }

    public function getLastPhoneNumber(): string
    {
        if(empty($phone = $this->session->get(self::SESSION_PHONE_KEY))) {
            throw new \DomainException('Ошибка получения последнего введенного номера телефона.');
        }

        return $phone;
    }

    public function saveCredentials($email, $phone)
    {
        $this->session->put(self::SESSION_EMAIL_KEY, $email);
        $this->session->put(self::SESSION_PHONE_KEY, $phone);
    }

    public function sendPhoneConfirmCode(User $user, Carbon $expiredDate): void
    {
        if(empty($user->phone)) {
            throw new \DomainException('Телефон не заполнен.');
        }
        $code = $this->codeGenerator->generate();

        $user->update(['verification_phone_code' => $code, 'phone_code_expires' => $expiredDate]);
        $this->smsSender->send($user->phone, $code);
    }

    public function attachPhone(User $user, string $phone): void
    {
        $user->update(['phone' => $phone]);
    }

    public function attachEmail(User $user, string $email): void
    {
        $user->update(['email' => $email]);
    }

    public function checkPhoneConfirmCode(int $code, User $user): void
    {
        if(empty($user->phone)) {
            throw new \DomainException('Телефон не заполнен.');
        }
        if($user->verification_phone_code !== $code) {
            throw new \DomainException('Проверочный код не верный.');
        }

        if($user->isPhoneTokenExpired()) {
            throw new \DomainException('Проверочный код не действительный.');
        }
    }
}

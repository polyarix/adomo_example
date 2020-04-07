<?php

namespace App\Http\Controllers\Admin\Users;

use App\Entity\Location\City;
use App\Entity\User\AdminUser as User;
use App\Entity\User\Verification\Document;
use App\Http\Requests\Admin\User\User\BanRequest;
use App\Http\Requests\Admin\User\User\PremiumRequest;
use App\UseCase\User\UserService;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use App\Http\Requests\Admin\User\User\StoreRequest;
use App\Http\Requests\Admin\User\User\UpdateRequest;
use Backpack\CRUD\CrudPanel;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * Class UsersController
 * @package App\Http\Controllers\Admin\Users
 * @property-read CrudPanel $crud
 */
class UsersController extends CrudController
{
    /**
     * @var UserService
     */
    private $userService;

    public function __construct(UserService $userService)
    {
        parent::__construct();
        $this->userService = $userService;
    }

    public function setup()
    {
        $this->crud->setModel(User::class);
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/users');
        $this->crud->setEntityNameStrings('user', 'users');

        $this->crud->addFilter(['type' => 'text', 'name' => 'id', 'label'=> 'ID'],
            false,
            function($value) {
                $this->crud->addClause('where', 'id', $value);
            });

        $this->crud->addFilter(['name' => 'status', 'type' => 'select2', 'label'=> 'Статус'], function() {
            return User::getStatusList();
        }, function($value) {
            $this->crud->addClause('where', 'status', $value);
        });

        $this->crud->addFilter(['name' => 'city', 'type' => 'select2', 'label'=> 'Город'], function() {
            $data = [];
            foreach(City::select(['id', 'name'])->get() as $city) {
                $data[$city->id] = $city->name;
            }

            return $data;
        }, function($value) {
            $this->crud->addClause('where', 'city_id', $value);
        });

        $this->crud->addFilter(['name' => 'type', 'type' => 'select2', 'label'=> 'Тип'], function() {
            return User::getTypes();
        }, function($value) {
            if($value === User::TYPE_CUSTOMER) {
                $this->crud->addClause('where', 'type', $value);
            } else {
                $this->crud->addClause('whereHas', 'workData', function($q) use($value) {
                    $q->where('team_type', $value);
                });
            }
        });

        $this->crud->addFilter(['name' => 'role', 'type' => 'select2', 'label'=> 'Роль'], function() {
            return User::getRoles();
        }, function($value) {
            $this->crud->addClause('where', 'role', $value);
        });

        $this->crud->addFilter(['name' => 'sex', 'type' => 'select2', 'label'=> 'Пол'], function() {
            return ['женский', 'мужской'];
        }, function($value) {
            $this->crud->addClause('where', 'sex', $value);
        });

        $this->crud->addFilter(['type' => 'simple', 'name' => 'draft', 'label'=> 'Активный премиум'], false,
        function() {
            $this->crud->addClause('where', 'premium_to', '>=', Carbon::now());
        });

        $this->crud->addFilter(['type' => 'text', 'name' => 'phone', 'label'=> 'Телефон'],
        false,
        function($value) {
            $this->crud->addClause('where', 'phone', 'LIKE', "%$value%");
        });

        $this->crud->addFilter(['type' => 'text', 'name' => 'email', 'label'=> 'Email'],
        false,
        function($value) {
            $this->crud->addClause('where', 'email', 'LIKE', "%$value%");
        });

        $this->crud->addFilter(['name' => 'verification', 'type' => 'select2', 'label'=> 'Верификация'], function() {
            return ['Не верифицирован', 'Верифицирован'];
        }, function($value) {
            $this->crud->addClause('where', 'is_verified', (bool)$value);
        });

        $this->crud->disableResponsiveTable();
        $this->crud->addColumns([
            ['name' => 'id', 'label' => 'ID'],
            ['name' => 'first_name', 'label' => 'Имя'],
            ['name' => 'email', 'label' => 'Email', 'type' => 'text'],
            ['name' => 'phone', 'label' => 'Телефон', 'type' => 'text'],
            ['name' => 'city.name', 'label' => 'Город', 'type' => 'text'],
            ['name'  => 'type', 'label' => 'Тип', 'type' => 'select_from_array', 'options' => User::getOriginalTypes(), 'tab' => 'Личные данные'],
            ['name'  => 'role', 'label' => 'Роль', 'type' => 'select_from_array', 'options' => User::getRoles(), 'tab' => 'Личные данные'],
            ['name' => 'status', 'type' => 'radio', 'label' => 'Статус', 'options' => User::getStatusList()],
            ['name' => 'sex', 'type' => 'select_from_array', 'label' => 'Пол', 'options' => ['женский', 'мужской']],
            ['name' => 'created_at', 'type' => 'datetime', 'label' => 'Дата регистрации'],
            ['name' => 'rating', 'label' => 'Рейтинг', 'default' => 0],
        ]);

        $this->crud->addButtonFromView('line', 'user_actions', 'user_actions', 'beginning');
        $this->crud->addButtonFromView('line', 'status', 'status', 'beginning');

        $this->crud->orderBy('unverified_documents_count', 'DESC');
        $this->crud->orderBy('id', 'DESC');

        $this->crud->setRequiredFields(StoreRequest::class, 'create');
        $this->crud->setRequiredFields(UpdateRequest::class, 'update');

        $this->crud->setListView('admin.user.user.list');

        $this->crud->allowAccess('show');

        /** @var User $user */
        $user = \Auth::user();

        $roles = $user->isAdmin() ? User::getRoles() : Arr::except(User::getRoles(), User::ROLE_ADMIN);

        $this->crud->addFields([
            ['name'  => 'first_name', 'label' => 'Имя', 'type'  => 'text', 'tab' => 'Личные данные'],
            ['name'  => 'last_name', 'label' => 'Фамилия', 'type'  => 'text', 'tab' => 'Личные данные'],
            ['name'  => 'email', 'label' => 'Email', 'type'  => 'text', 'tab' => 'Личные данные'],
            ['name'  => 'phone', 'label' => 'Телефон', 'type'  => 'text', 'tab' => 'Личные данные'],
            ['name'  => 'sex', 'label' => 'Пол', 'type'  => 'select_from_array', 'options' => ['женский', 'мужской'], 'tab' => 'Личные данные', 'allows_null' => true],
            ['name'  => 'city_id', 'label' => 'Город', 'type'  => 'select', 'tab' => 'Личные данные', 'attribute' => 'name', 'model' => City::class, 'entity' => 'city'],
            ['name'  => 'birth_date', 'label' => 'Дата рождения', 'type'  => 'date_flatpicker', 'tab' => 'Личные данные'],
            ['name'  => 'about', 'label' => 'О себе', 'type' => 'textarea', 'tab' => 'Личные данные'],
            ['name'  => 'type', 'label' => 'Тип', 'type' => 'select_from_array', 'options' => User::getOriginalTypes(), 'tab' => 'Личные данные', 'allows_null' => true],
            ['name'  => 'role', 'label' => 'Роль', 'type' => 'select_from_array', 'options' => $roles, 'tab' => 'Личные данные'],
            ['name'  => 'photo', 'label' => 'Аватар', 'type' => 'image', 'tab' => 'Личные данные', 'width' => '50px', 'upload' => true, 'crop' => false, 'disk' => 'public'],
            ['name'  => 'password', 'label' => 'Пароль', 'type' => 'password', 'tab' => 'Личные данные'],
            ['name'  => 'password_confirmation', 'label' => 'Повтор пароль', 'type' => 'password', 'tab' => 'Личные данные'],

            ['name'  => 'passport_series', 'label' => 'Серия паспорта', 'tab' => 'Данные верификации'],
            ['name'  => 'registration', 'label' => 'Прописка', 'tab' => 'Данные верификации'],
            ['name'  => 'criminal_record', 'label' => 'Судимость', 'type' => 'boolean', 'tab' => 'Данные верификации'],
            ['name'  => 'is_verified', 'label' => 'Верифицированный пользователь', 'type' => 'boolean', 'tab' => 'Данные верификации'],
            [   // Upload
                'name' => 'documents',
                'label' => 'Документы и сертификаты',
                'type' => 'user_documents',
                'upload' => true,
                'tab' => 'Данные верификации'
            ],
        ]);
    }

    public function edit($id)
    {
        if($action = $this->request->get('action')) {
            try {
                /** @var Document $doc */
                $doc = Document::findOrFail($this->request->get('doc'));

                switch ($action) {
                    case 'private': $doc->setPrivate(); break;
                    case 'public': $doc->setPublic(); break;
                    case 'verify': $doc->verify(Carbon::now()); break;
                    case 'reject': $doc->reject(Carbon::now()); break;
                    case 'remove': $this->removeDoc($doc); break;
                }
                \Alert::success('Документ успешно обновлён.')->flash();
            } catch (\Exception $e) {
                \Alert::error($e->getMessage())->flash();
            }

            return redirect()->back();
        }

        return parent::edit($id);
    }

    public function activate($id)
    {
        $user = $this->getUser($id);

        try {
            $this->userService->activate($user);

            \Alert::success('User successful moderated.')->flash();

            return redirect()->back();
        } catch (\Exception $e) {
            \Alert::error($e->getMessage())->flash();

            return redirect()->back();
        }
    }

    public function ban($id, BanRequest $request)
    {
        $user = $this->getUser($id);

        try {
            $this->userService->ban($user, $request);

            \Alert::success('User successful banned.')->flash();

            return redirect()->route('crud.users.index');
        } catch (\Exception $e) {
            \Alert::error($e->getMessage())->flash();

            return redirect()->back()->withInput($request->all());
        }
    }

    public function premium($id, PremiumRequest $request)
    {
        $user = $this->getUser($id);

        try {
            $this->userService->extendPremium($user, $request->get('count'));

            \Alert::success('User premium was extended.')->flash();

            return redirect()->route('crud.users.index');
        } catch (\Exception $e) {
            \Alert::error($e->getMessage())->flash();

            return redirect()->back()->withInput($request->all());
        }
    }

    public function stripPremium($id)
    {
        $user = $this->getUser($id);

        try {
            $this->userService->stripPremium($user);

            \Alert::success('User premium was striped.')->flash();

            return redirect()->route('crud.users.index');
        } catch (\Exception $e) {
            \Alert::error($e->getMessage())->flash();

            return redirect()->back();
        }
    }

    public function premiumForm($id)
    {
        $user = $this->getUser($id);

        if(!$user->isActive()) {
            \Alert::error('Premium can be only active user.')->flash();

            return redirect()->back();
        }

        return view('admin.user.user.premium', ['user' => $user, 'crud' => $this->crud, 'entry' => $user]);
    }

    public function banForm($id)
    {
        $user = $this->getUser($id);

        if($user->isBanned()) {
            \Alert::error('User already banned.')->flash();

            return redirect()->route('crud.users.index');
        }

        return view('admin.user.user.ban', ['user' => $user, 'crud' => $this->crud, 'entry' => $user]);
    }

    public function unban($id)
    {
        $user = $this->getUser($id);

        try {
            $this->userService->unban($user);

            \Alert::success('User successful unbanned.')->flash();

            return redirect()->back();
        } catch (\Exception $e) {
            \Alert::error($e->getMessage())->flash();

            return redirect()->back();
        }
    }

    public function store(Request $request)
    {
        try {
            $result = $this->storeCrud();
        } catch (\Exception $e) {
            $message = $e->getMessage();
            if($e instanceof QueryException) {
                $message = 'Пользователь должен иметь уникальный телефон и почту.';
            }

            \Alert::error($message)->flash();

            return redirect()->back()->withInput($request->all());
        }

        $this->userService->activate($this->crud->entry);

        return $result;
    }

    public function update($id)
    {
        $user = $this->getUser($id);
        $prevPhoto = $user->photo;

        if(!empty($prevPhoto) && Str::endsWith($this->crud->request['photo'], $prevPhoto)) {
            $this->crud->request->request->set('photo', $prevPhoto);
        }

        $this->crud->request = $this->handlePasswordInput($this->crud->request);

        return $this->updateCrud();
    }

    public function show($id)
    {
        $user = $this->getUser($id);

        $this->crud->addColumns([
            ['name' => 'id', 'label' => 'ID'],
            ['name' => 'first_name', 'label' => 'Имя'],
            ['name' => 'last_name', 'label' => 'Фамилия'],
            ['name' => 'email', 'label' => 'Email', 'type' => 'text'],
            ['name' => 'phone', 'label' => 'Телефон', 'type' => 'text'],
            ['name' => 'city.name', 'label' => 'Город', 'type' => 'text'],
            ['name'  => 'birth_date', 'label' => 'Дата рождения', 'type'  => 'date', 'tab' => 'Личные данные'],
            ['name'  => 'about', 'label' => 'О себе', 'type' => 'textarea', 'tab' => 'Личные данные'],
            ['name'  => 'type', 'label' => 'Тип', 'type' => 'select_from_array', 'options' => User::getTypes(), 'tab' => 'Личные данные'],
            ['name'  => 'role', 'label' => 'Роль', 'type' => 'select_from_array', 'options' => User::getRoles(), 'tab' => 'Личные данные'],
            ['name' => 'status', 'type' => 'radio', 'label' => 'Статус', 'options' => User::getStatusList()],
            ['name' => 'sex', 'type' => 'select_from_array', 'label' => 'Пол', 'options' => ['женский', 'мужской']],
            ['name'  => 'photo', 'label' => 'Аватар', 'type' => 'image', 'prefix' => 'storage/', 'width' => '100px', 'height' => '100px'],
            ['name'  => 'email_verified_at', 'label' => 'Время подтверждения почты', 'type' => 'text'],
            ['name'  => 'verification_email_code', 'label' => 'Код подтверждения почты', 'type' => 'text'],
            ['name'  => 'phone_verified_at', 'label' => 'Время подтверждения телефона', 'type' => 'text'],
            ['name'  => 'verification_phone_code', 'label' => 'Код подтверждения телефона', 'type' => 'text'],
            ['name'  => 'banned_at', 'label' => 'Дата начала бана', 'type' => 'text'],
            ['name'  => 'banned_to', 'label' => 'Забанен до', 'type' => 'text'],
            ['name'  => 'ban_reason', 'label' => 'Причина бана', 'type' => 'text'],
            ['name'  => 'premium_to', 'label' => 'Время действия премиума', 'type' => 'text'],
            ['name'  => 'rating', 'label' => 'Рейтинг', 'type' => 'text'],
            ['name'  => 'registration', 'label' => 'Прописка', 'type' => 'text'],
            ['name'  => 'passport_series', 'label' => 'Серия/номер паспорта', 'type' => 'text'],
            ['name'  => 'criminal_record', 'label' => 'Судимость', 'type' => 'boolean'],
            ['name'  => 'is_verified', 'label' => 'Проверенный пользователь', 'type' => 'boolean'],
            [
                'name' => 'counter',
                'label' => 'Статистика в цифрах',
                'type' => $user->isCustomer() ? 'customer_counter' : 'executor_counter',
            ],
        ]);

        $content =  parent::show($id);

        $this->crud->removeColumns(['phone_code_expires', 'city_id']);
        $this->crud->removeFields(['phone_code_expires', 'city_id']);

        return $content;
    }

    protected function handlePasswordInput(Request $request)
    {
        $request->request->remove('password_confirmation');
        $request->request->remove('permissions_show');

        if ($request->input('password')) {
            $request->request->set('password', Hash::make($request->input('password')));
        } else {
            $request->request->remove('password');
        }
        return $request;
    }

    private function getUser($id): User
    {
        $user = User::findOrFail($id);

        return $user;
    }

    private function removeDoc(Document $document)
    {
        if(!$document->isRejected()) {
            throw new \DomainException('Only rejected documents can be removed.');
        }

        \Storage::delete($document->getCrop());
        \Storage::delete($document->getPath());
        $document->delete();
    }
}

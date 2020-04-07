<?php

namespace App\Entity\User;

use App\Entity\Advert\Advert\Order;
use App\Entity\Advert\Advert\Service;
use App\Entity\Advert\Advert\BaseAdvertModel;
use App\Entity\Location\City;
use App\Entity\User\Company\Company;
use App\Entity\User\Executor\WorkData;
use App\Entity\User\Portfolio\Album;
use App\Entity\User\Verification\Document;
use App\Helpers\Models\ImageHandlerTrait;
use App\Notifications\User\Verification\EmailCodeNotification;
use App\Notifications\User\ResetPasswordNotification;
use Backpack\CRUD\CrudTrait;
use Carbon\Carbon;
use Illuminate\Contracts\Auth\CanResetPassword;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Entity\Advert\Advert\Order\Review;
use App\Entity\Advert\Advert\Order\Request;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements MustVerifyEmail, CanResetPassword
{
    use Notifiable, CrudTrait, ImageHandlerTrait;

    const STORAGE_PATH = 'avatar';

    const ROLE_USER = 'user';
    const ROLE_MANAGER = 'manager';
    const ROLE_ADMIN = 'admin';

    const STATUS_NEW = 'new';
    const STATUS_ACTIVE = 'active';
    const STATUS_BANNED = 'banned';

    const TYPE_CUSTOMER = 'customer';
    const TYPE_EXECUTOR = 'executor';

    const RATING_VERIFY_DOCUMENT_POINTS = 1;
    const RATING_VERIFY_PASSPORT_POINTS = 5;
    const RATING_POSITIVE_REVIEW_POINTS = 5;
    const RATING_NEGATIVE_REVIEW_POINTS = -10;
    const RATING_CONFIRM_CREDENTIALS_POINTS = 10;
    const RATING_CREATE_PORTFOLIO_ALBUM_POINTS = 3;

    protected $fillable = [
        'first_name', 'last_name', 'sex', 'birth_date', 'phone', 'email', 'password', 'role', 'status', 'type', 'photo', 'rating', 'banned_at', 'banned_to', 'ban_reason', 'email_verified_at', 'phone_verified_at', 'verification_email_code', 'verification_phone_code', 'phone_code_expires', 'premium_to', 'about', 'city_id', 'passport_series', 'registration', 'criminal_record', 'is_verified',
    ];

    protected $image_attributes = ['photo'];

    protected $withCount = ['reviews', 'positiveReviews'];
    protected $with = ['avgReviewsRating', 'reviews'];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'phone_verified_at' => 'datetime',
        'banned_at' => 'datetime',
        'banned_to' => 'datetime',
        'phone_code_expires' => 'datetime',
        'premium_to' => 'datetime',
        'email_code' => 'integer',
        'verification_phone_code' => 'integer',
        'verification_email_code' => 'integer',
        'criminal_record' => 'boolean',
        'is_verified' => 'boolean',
        'rating' => 'float',
    ];

    public static function registerByNetwork(string $network, string $identity, string $type, ?string $email = null): self
    {
        if(!array_key_exists($type, self::getTypes())) {
            throw new \InvalidArgumentException("Unable to register type {$type}.");
        }

        $user = static::create([
            'email' => $email,
            'password' => null,
            'verify_token' => null,
            'role' => self::ROLE_USER,
            'status' => self::STATUS_ACTIVE,
            'type' => $type
        ]);
        $user->networks()->create([
            'network' => $network,
            'identity' => $identity,
        ]);
        return $user;
    }

    public function setPremium(?Carbon $date = null)
    {
        $this->update(['premium_to' => $date]);
    }

    public function activate(Carbon $date)
    {
        if($this->isActive()) {
            throw new \DomainException('User is already activated.');
        }
        $this->confirmEmail($this->email_verified_at ?? $date);
        $this->confirmPhone($this->phone_verified_at ?? $date);
        $this->update(['status' => self::STATUS_ACTIVE]);
    }

    public function ban(Carbon $date, Carbon $banTo, ?string $reason = null)
    {
        if(!$this->isActive()) {
            throw new \DomainException('Only active users can be banned.');
        }
        if($banTo->lt($date)) {
            throw new \InvalidArgumentException('Ban date less than current.');
        }
        $this->update(['status' => self::STATUS_BANNED, 'banned_at' => $date, 'banned_to' => $banTo, 'ban_reason' => $reason]);
    }

    public function unban()
    {
        if(!$this->isBanned()) {
            throw new \DomainException('User already unbaned.');
        }
        $this->update(['status' => self::STATUS_ACTIVE, 'banned_to' => null]);
    }

    public function confirmEmail(Carbon $date)
    {
        $this->update(['email_verified_at' => $date, 'verification_email_code' => null]);
    }

    public function confirmPhone(Carbon $date)
    {
        $this->update(['phone_verified_at' => $date, 'verification_phone_code' => null, 'phone_code_expires' => null]);
    }

    public function networks()
    {
        return $this->hasMany(Network::class, 'user_id', 'id');
    }
    public function orders()
    {
        return $this->hasMany(Order::class, 'user_id', 'id');
    }
    public function city()
    {
        return $this->belongsTo(City::class, 'city_id', 'id');
    }
    public function workData()
    {
        return $this->hasOne(WorkData::class);
    }
    public function services()
    {
        return $this->hasMany(Service::class, 'user_id', 'id');
    }
    public function documents()
    {
        return $this->hasMany(Document::class);
    }
    public function reviews()
    {
        return $this->hasMany(Review::class, 'target_id', 'id');
    }
    public function albums()
    {
        return $this->hasMany(Album::class);
    }
    public function positiveReviews()
    {
        return $this->hasMany(Review::class, 'target_id', 'id')->where('avg', '>=', 3);
    }
    public function avgReviewsRating()
    {
        return $this->reviews()
            ->selectRaw('avg(avg) as aggregate, target_id')
            ->groupBy('target_id');
    }
    public function orderRequests()
    {
        return $this->hasMany(Request::class);
    }
    public function performOrders()
    {
        return $this->hasMany(Order::class, 'executor_id', 'id');
    }

    public function company()
    {
        return $this->hasMany(Company::class);
    }

    public function getCity()
    {
        return $this->city ? $this->city->name : '';
    }

    public function scopeByNetwork(Builder $query, string $network, string $identity): Builder
    {
        return $query->whereHas('networks', function(Builder $query) use ($network, $identity) {
            $query->where('network', $network)->where('identity', $identity);
        });
    }
    public function scopeCustomer(Builder $query): Builder
    {
        return $query->where('type', self::TYPE_CUSTOMER);
    }
    public function scopeExecutor(Builder $query): Builder
    {
        return $query->where('type', self::TYPE_EXECUTOR);
    }
    public function scopeActivePremium(Builder $query): Builder
    {
        return $query->where('premium_to', '>=', Carbon::now());
    }
    public function scopeWithoutPremium(Builder $query): Builder
    {
        return $query->whereNull('premium_to')->orWhere('premium_to', '<', Carbon::now());
    }

    public function hasFilledContactData(): bool
    {
        return !empty($this->passport_series) && !empty($this->registration);
    }
    public function hasCriminalRecord(): bool
    {
        return is_null($this->criminal_record) || (bool)$this->criminal_record === false;
    }
    public function hasFilledProfile(): bool
    {
        return $this->hasVerifiedEmail() && $this->hasVerifiedPhone() && !empty($this->first_name) && !empty($this->last_name)&& !empty($this->sex);
    }
    public function hasVerifiedPhone()
    {
        return !empty($this->phone_verified_at);
    }
    public function isPhoneTokenExpired(): bool
    {
        return $this->phone_code_expires->lt(Carbon::now());
    }

    public function isNew(): bool
    {
        return $this->status === self::STATUS_NEW;
    }
    public function isActive(): bool
    {
        return $this->status === self::STATUS_ACTIVE;
    }
    public function isBanned(): bool
    {
        return $this->status === self::STATUS_BANNED;
    }
    public function isUnderBan(): bool
    {
        return $this->isBanned() && $this->banned_to && $this->banned_to->gt(Carbon::now());
    }

    public function isAdmin(): bool
    {
        return $this->role === self::ROLE_ADMIN;
    }
    public function isManager(): bool
    {
        return $this->role === self::ROLE_MANAGER;
    }

    public function isExecutor(): bool
    {
        return $this->type === self::TYPE_EXECUTOR;
    }
    public function isCustomer(): bool
    {
        return $this->type === self::TYPE_CUSTOMER;
    }

    public function isConfirmed(): bool
    {
        return (bool)$this->is_verified;
    }
    public function isBestExecutor(): bool
    {
        return (bool)rand(0, 1) === 1;
    }
    public function hasPremium()
    {
        return $this->premium_to && $this->premium_to->gte(Carbon::now());
    }

    public function getName()
    {
        return "{$this->first_name} {$this->last_name}";
    }

    public function addRating(float $points)
    {
        $this->update(['rating' => $points + $this->getRating()]);
    }
    public function getAvgRatingAttribute()
    {
        if (!array_key_exists('avgReviewsRating', $this->relations)) {
            $this->load('avgReviewsRating');
        }

        $relation = $this->getRelation('avgReviewsRating')->first();

        return ($relation) ? $relation->aggregate : 0;
    }
    public function getRating(): float
    {
        return (float)$this->rating;
    }
    public function getPositiveReviewsPercent()
    {
        if($this->reviews_count === 0 || $this->positive_reviews_count === 0) {
           return 0;
        }

        return round(100 - ($this->reviews_count - $this->positive_reviews_count) / $this->reviews_count * 100, 0);
    }
    public function getStarRating()
    {
        return round($this->avgRating);
    }

    public function hasAvatar(): bool
    {
        return !empty($this->photo);
    }
    public function getAvatar()
    {
        if(!$this->photo) {
            return 'images/userpic.svg';
        }

        return 'storage/' . $this->photo;
    }

    public function getAge()
    {
        return Carbon::parse($this->birth_date)->age;
    }

    public function sendEmailVerificationNotification()
    {
        $this->notify(new EmailCodeNotification());
    }

    public function getType()
    {
        return data_get(self::getTypes(), $this->type, 'Неизвестный тип');
    }

    public function authorOf(Order $order): bool
    {
        return $order->user_id === $this->id;
    }
    public function authorOfService(Service $service): bool
    {
        return $service->user_id === $this->id;
    }
    public function isExecutorFor(Order $order): bool
    {
        return $order->executor_id === $this->id;
    }

    public static function getTypes(): array
    {
        return [
            self::TYPE_EXECUTOR => 'Исполнитель',
            self::TYPE_CUSTOMER => 'Заказчик',
        ];
    }
    public static function getRoles(): array
    {
        return [
            self::ROLE_USER => 'Пользователь',
            self::ROLE_MANAGER => 'Менеджер',
            self::ROLE_ADMIN => 'Админ',
        ];
    }
    public static function getStatusList(): array
    {
        return [
            self::STATUS_ACTIVE => 'Активен',
            self::STATUS_NEW => 'Новый',
            self::STATUS_BANNED => 'Забанен',
        ];
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token));
    }

    /**
     * @return int
     */
    public static function getTotalCount(): int
    {
        return self::count();
    }

    /**
     * @return int
     */
    public static function getCustomersCount(): int
    {
        return self::customer()->count();
    }

    /**
     * @return int
     */
    public static function getExecutorsCount(): int
    {
        return self::executor()->count();
    }

    /**
     * @return int
     */
    public function getExecutorsCompletedOrdersCount(): int
    {
        return $this->performOrders()->where('status', BaseAdvertModel::STATUS_COMPLETED)->count();
    }

    /**
     * @return int
     */
    public function getExecutorsActiveOrdersCount(): int
    {
        return $this->performOrders()->where('status', BaseAdvertModel::STATUS_ACTIVE)->count();
    }

    /**
     * @return int
     */
    public function getExecutorsWorkingOrdersCount(): int
    {
        return $this->performOrders()->where('status', BaseAdvertModel::STATUS_WORKING)->count();
    }

    /**
     * @return int
     */
    public function getExecutorsModerationOrdersCount(): int
    {
        return $this->performOrders()->where('status', BaseAdvertModel::STATUS_MODERATION)->count();
    }

    /**
     * @return int
     */
    public function getExecutorsFinishedOrdersCount(): int
    {
        return $this->performOrders()->where('status', BaseAdvertModel::STATUS_FINISHED)->count();
    }

    /**
     * @return int
     */
    public function getExecutorsRejectedOrdersCount(): int
    {
        return $this->performOrders()->where('status', BaseAdvertModel::STATUS_REJECTED)->count();
    }

    /**
     * @return int
     */
    public function getExecutorsExpiredOrdersCount(): int
    {
        return $this->performOrders()->where('status', BaseAdvertModel::STATUS_EXPIRED)->count();
    }

    /**
     * @return int
     */
    public function getExecutorsClosedOrdersCount(): int
    {
        return $this->performOrders()->where('status', BaseAdvertModel::STATUS_CLOSED)->count();
    }

    /**
     * @return int
     */
    public function getExecutorsSpamOrdersCount(): int
    {
        return $this->performOrders()->where('status', BaseAdvertModel::STATUS_SPAM)->count();
    }

    /**
     * @return int
     */
    public function getCustomersCompletedOrdersCount(): int
    {
        return $this->orders()->where('status', BaseAdvertModel::STATUS_COMPLETED)->count();
    }

    /**
     * @return int
     */
    public function getCustomersActiveOrdersCount(): int
    {
        return $this->orders()->where('status', BaseAdvertModel::STATUS_ACTIVE)->count();
    }

    /**
     * @return int
     */
    public function getCustomersModerationOrdersCount(): int
    {
        return $this->orders()->where('status', BaseAdvertModel::STATUS_MODERATION)->count();
    }

    /**
     * @return int
     */
    public function getCustomersFinishedOrdersCount(): int
    {
        return $this->orders()->where('status', BaseAdvertModel::STATUS_FINISHED)->count();
    }

    /**
     * @return int
     */
    public function getCustomersRejectedOrdersCount(): int
    {
        return $this->orders()->where('status', BaseAdvertModel::STATUS_REJECTED)->count();
    }

    /**
     * @return int
     */
    public function getCustomersExpiredOrdersCount(): int
    {
        return $this->orders()->where('status', BaseAdvertModel::STATUS_EXPIRED)->count();
    }

    /**
     * @return int
     */
    public function getCustomersClosedOrdersCount(): int
    {
        return $this->orders()->where('status', BaseAdvertModel::STATUS_CLOSED)->count();
    }

    /**
     * @return int
     */
    public function getCustomersSpamOrdersCount(): int
    {
        return $this->orders()->where('status', BaseAdvertModel::STATUS_SPAM)->count();
    }

    /**
     * @return int
     */
    public function getCustomerOrdersCount(): int
    {
        return $this->orders()->count();
    }

    /**
     * @return int
     */
    public function getExecutorOrdersCount(): int
    {
        return $this->performOrders()->count();
    }
}

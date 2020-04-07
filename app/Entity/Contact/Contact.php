<?php

namespace App\Entity\Contact;

use Backpack\CRUD\CrudTrait;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    const TYPE_OFFER = 'offer'; // предложение
    const TYPE_REQUEST = 'request'; // запрос в поддержку

    const STATUS_NEW = 'new';
    const STATUS_RESPOND = 'respond';

    use CrudTrait;

    protected $table = 'contact_requests';
    protected $fillable = ['name', 'phone', 'text', 'email', 'type', 'viewed', 'status', 'response_text', 'respond_at'];

    protected $casts = [
        'viewed' => 'boolean',
        'respond_at' => 'datetime'
    ];

    public function respond(Carbon $date, string $message)
    {
        return $this->update(['response_text' => $message, 'respond_at' => $date, 'viewed' => true, 'status' => self::STATUS_RESPOND]);
    }
    public function setViewed()
    {
        return $this->update(['viewed' => true]);
    }

    public function scopeOffers($query)
    {
        return $query->where('type', self::TYPE_OFFER);
    }
    public function scopeRequests($query)
    {
        return $query->where('type', self::TYPE_REQUEST);
    }
    public function scopeViewed($query)
    {
        return $query->where('viewed', true);
    }
    public function scopeNew($query)
    {
        return $query->where('viewed', false);
    }

    public function isRespond(): bool
    {
        return $this->status === self::STATUS_RESPOND;
    }
    public function isNew(): bool
    {
        return $this->status === self::STATUS_NEW;
    }
    public function isViewed(): bool
    {
        return $this->viewed === true;
    }

    public function isOffer(): bool
    {
        return $this->type === self::TYPE_OFFER;
    }

    public static function getTypesList(): array
    {
        return [
            self::TYPE_REQUEST => 'Запрос',
            self::TYPE_OFFER => 'Предложение',
        ];
    }
    public static function getStatusesList(): array
    {
        return [
            self::STATUS_NEW => 'Открыто',
            self::STATUS_RESPOND => 'Закрыто',
        ];
    }
    public static function getStatusClasses(): array
    {
        return [
            self::STATUS_NEW => 'secondary',
            self::STATUS_RESPOND => 'success',
        ];
    }
}

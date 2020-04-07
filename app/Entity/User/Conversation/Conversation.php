<?php

namespace App\Entity\User\Conversation;

use App\Entity\Advert\Advert\Order;
use App\Entity\User\Company\Company;
use App\Entity\User\User;
use Illuminate\Database\Eloquent\Model;

class Conversation extends Model
{
    protected $table = 'chat_conversations';
    public $timestamps = true;
    public $fillable = [
        'user_one',
        'user_two',
        'status',
        'order_id',
        'company_id',
        'theme',
    ];

    /*
     * make a relation between message
     *
     * return collection
     * */
    public function messages()
    {
        return $this->hasMany(Message::class, 'conversation_id')->with(['sender', 'attachments']);
    }

    public function unreadMessages()
    {
        return $this->hasMany(Message::class, 'conversation_id')
            ->with(['sender', 'attachments'])
            ->where('is_seen', false)
        ;
    }

    /*
     * make a relation between first user from conversation
     *
     * return collection
     * */
    public function userone()
    {
        return $this->belongsTo(User::class,  'user_one', config('talk.user.ownerKey'));
    }

    /*
   * make a relation between second user from conversation
   *
   * return collection
   * */
    public function usertwo()
    {
        return $this->belongsTo(User::class,  'user_two', config('talk.user.ownerKey'));
    }

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }
    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }

    public function isByOrder(): bool
    {
        return !empty($this->order);
    }
    public function isByCompany(): bool
    {
        return !empty($this->company);
    }
}

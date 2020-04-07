<?php

namespace App\Entity\User\Conversation;

use App\Entity\User\User;
use Embera\Embera;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Model;
use Nahid\Talk\Html\HtmlString;
use Nahid\Talk\Html\HtmlStringInterface;

class Message extends Model implements HtmlStringInterface
{
    const TYPE_MESSAGE = 'message';
    const TYPE_SUCCESS_NOTIFICATION = 'success';
    const TYPE_WARNING_NOTIFICATION = 'warning';

    protected $table = 'chat_messages';

    public $timestamps = true;

    protected $appends = ['humans_time'];

    public $fillable = [
        'message',
        'is_seen',
        'deleted_from_sender',
        'deleted_from_receiver',
        'user_id',
        'conversation_id',
        'type'
    ];

    /*
     * make dynamic attribute for human readable time
     *
     * @return string
     * */
    public function getHumansTimeAttribute()
    {
        $date = $this->created_at;
        $now = $date->now();

        return $date->diffForHumans($now, true);
    }
    /*
     * make a relation between conversation model
     *
     * @return collection
     * */
    public function conversation()
    {
        return $this->belongsTo(Conversation::class);
    }
    /*
   * make a relation between user model
   *
   * @return collection
   * */
    public function user()
    {
        return $this->belongsTo(User::class, config('talk.user.foreignKey'), config('talk.user.ownerKey'));
    }
    /*
   * its an alias of user relation
   *
   * @return collection
   * */
    public function sender()
    {
        return $this->user();
    }

    public function attachments()
    {
        return $this->hasMany(Attachment::class);
    }

    public function hasAttachments(): bool
    {
        return !empty($this->attachments);
    }
    public function isMessageType(): bool
    {
        return $this->type === self::TYPE_MESSAGE;
    }
    public function isSuccessNotificationType(): bool
    {
        return $this->type === self::TYPE_SUCCESS_NOTIFICATION;
    }
    public function isWarningNotificationType(): bool
    {
        return $this->type === self::TYPE_WARNING_NOTIFICATION;
    }

    /**
     * @return Htmlable
     */
    public function toHtmlString()
    {
        $embera = new Embera(['http' => ['curl' => [CURLOPT_SSL_VERIFYPEER => false]]]);

        return new HtmlString($this->message, $embera);
    }
}

<?php

namespace App\Entity\Blog;

use App\Entity\User\User;
use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\CrudTrait;

class Comment extends Model
{
    use CrudTrait;

    const STATUS_ACTIVE = 'active';
    const STATUS_MODERATION = 'moderation';

    protected $table = 'blog_article_comments';
    protected $fillable = ['text', 'user_id', 'article_id', 'status', 'type'];

    public function moderate(): void
    {
        if($this->isActive()) {
            throw new \DomainException('The comment is already moderated.');
        }
        $this->update(['status' => self::STATUS_ACTIVE]);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function article()
    {
        return $this->belongsTo(Article::class);
    }

    public function isActive(): bool
    {
        return $this->status === self::STATUS_ACTIVE;
    }
    public function isOnModeration(): bool
    {
        return $this->status === self::STATUS_MODERATION;
    }

    public function scopeActive($q)
    {
        return $q->where('status', self::STATUS_ACTIVE);
    }
    public function scopeModeration($q)
    {
        return $q->where('status', self::STATUS_MODERATION);
    }

    public static function getStatusesList(): array
    {
        return [
            self::STATUS_ACTIVE => 'Опубликовано',
            self::STATUS_MODERATION => 'На модерации',
        ];
    }
}

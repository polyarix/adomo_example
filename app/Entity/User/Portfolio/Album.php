<?php

namespace App\Entity\User\Portfolio;

use App\Entity\Advert\Advert\Video;
use App\Entity\User\User;
use Illuminate\Database\Eloquent\Model;

class Album extends Model
{
    const PER_ALBUMS_PAGE = 2;

    protected $table = 'user_portfolio_albums';
    protected $fillable = ['title', 'description', 'preview_id', 'user_id'];

    protected $with = ['photos'];

    public function getPreview()
    {
        if(!empty($this->preview)) {
            return "/storage/{$this->preview->getPath()}";
        }

        return $this->photos->count() > 0 ? $this->photos->last()->getPath() : '';
    }
    public function getCrop()
    {
        if(!empty($this->preview)) {
            return "/storage/{$this->preview->getCrop()}";
        }

        return $this->photos->count() > 0 ? $this->photos->last()->getCrop() : '';
    }
    public function photos()
    {
        return $this->hasMany(Photo::class, 'album_id', 'id');
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function preview()
    {
        return $this->hasOne(Photo::class, 'album_id', 'preview_id');
    }
    public function videos()
    {
        return $this->morphMany(Video::class, 'morph');
    }
}

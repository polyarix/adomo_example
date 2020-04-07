<?php

namespace App\Entity\User\Company\Portfolio;

use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
    const MAX_ALLOWED_WIDTH = 1000; // 1000 px (if greater - going to be resized)

    protected $table = 'company_work_photos';
    protected $fillable = ['path', 'crop', 'work_id'];

    public $timestamps = false;

    public function getPath()
    {
        return "/storage/{$this->path}";
    }

    public function work()
    {
        return $this->belongsTo(Work::class);
    }

    public function hasCrop(): bool
    {
        return !empty($this->crop);
    }

    public function getCrop()
    {
        if(!$this->hasCrop()) {
            return $this->getPath();
        }

        return "/storage/{$this->crop}";
    }

    public function __toString()
    {
        return $this->getPath();
    }
}

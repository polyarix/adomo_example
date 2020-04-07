<?php

namespace App\Entity\User\Company\Portfolio;

use App\Entity\Advert\Advert\Video;
use App\Entity\User\Company\Company;
use App\Entity\User\User;
use Backpack\CRUD\CrudTrait;
use Illuminate\Database\Eloquent\Model;

class Work extends Model
{
    const PER_PAGE = 5;

    const DURATION_TYPE_DAYS = 'days';
    const DURATION_TYPE_MONTHS = 'months';

    use CrudTrait;

    protected $table = 'company_works';
    protected $fillable = ['title', 'description', 'price', 'duration', 'duration_type', 'preview_id', 'user_id', 'company_id'];

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

    public function getDurationType(): ?string
    {
        if(!$this->duration_type) {
            return null;
        }
        return data_get(self::getDurationTypes(), $this->duration_type);
    }
    public function isDurationFilled(): bool
    {
        return !empty($this->duration) && !empty($this->duration_type);
    }
    public function isDaysDuration(): bool
    {
        return $this->duration_type === self::DURATION_TYPE_DAYS;
    }
    public function isMonthsDuration(): bool
    {
        return $this->duration_type === self::DURATION_TYPE_MONTHS;
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
    public function photos()
    {
        return $this->hasMany(Photo::class, 'work_id', 'id');
    }
    public function videos()
    {
        return $this->hasMany(Video::class, 'morph_id', 'id')->where('morph_type', self::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function preview()
    {
        return $this->hasOne(Photo::class, 'album_id', 'preview_id');
    }

    public static function getDurationTypes(): array
    {
        return [
            self::DURATION_TYPE_MONTHS => 'месяцев',
            self::DURATION_TYPE_DAYS => 'дней',
        ];
    }

    public function getTitleWinkLink() {
        return '<a href="/admin/companies/'. $this->company->id .'" target="_blank">'.$this->company->name.'</a>';
    }
    public function getCompanyWithLink() {
        return '<a href="/admin/companies/'. $this->company->id .'" target="_blank">'.$this->company->name.'</a>';
    }
    public function getUserWithLink() {
        return '<a href="/admin/users/'. $this->user->id .'" target="_blank">'.$this->user->email.'</a>';
    }
}

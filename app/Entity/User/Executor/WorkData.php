<?php

namespace App\Entity\User\Executor;

use App\Entity\Advert\Category;
use App\Entity\Location\City;
use App\Entity\Location\District;
use Illuminate\Database\Eloquent\Model;

class WorkData extends Model
{
    const TYPE_INDIVIDUAL = 'individual'; // бригада
    const TYPE_BRIGADE = 'brigade'; // частный исполнитель

    const LEGAL_TYPE_PRIVATE = 'private'; // частное лицо
    const LEGAL_TYPE_LEGAL = 'legal'; // юридическое лицо
    const LEGAL_TYPE_IE = 'ie'; // ИП

    const POSITIVE_RATING_MIN_GRADE = 90;

    protected $table = 'user_executor_work_data';

    protected $fillable = ['legal_type', 'team_type', 'brigade_size', 'about', 'user_id', 'main_city_id', 'company_name', 'reviews_rating'];

    protected $casts = [
        'reviews_rating' => 'float'
    ];

    public function isBestExecutor(): bool
    {
        return $this->getReviewsRating() > self::POSITIVE_RATING_MIN_GRADE;
    }
    public function getReviewsRating(): float
    {
        return $this->reviews_rating;
    }

    public function isBrigade(): bool
    {
        return $this->team_type === self::TYPE_BRIGADE;
    }
    public function isIndividual(): bool
    {
        return $this->team_type === self::TYPE_INDIVIDUAL;
    }

    public function isIE(): bool
    {
        return $this->legal_type === self::LEGAL_TYPE_IE;
    }
    public function isLegalType(): bool
    {
        return $this->legal_type === self::LEGAL_TYPE_LEGAL;
    }
    public function isPrivateType(): bool
    {
        return $this->legal_type === self::LEGAL_TYPE_PRIVATE;
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'user_executor_categories', 'user_id', 'category_id', 'user_id')->withPivot('price');
    }
    public function city()
    {
        return $this->belongsTo(City::class, 'main_city_id', 'id');
    }
    public function districts()
    {
        return $this->belongsToMany(District::class, 'advert_districts', 'entity_id', 'district_id', 'user_id')->where('type', District::TYPE_USER);
    }

    public static function getTeamTypes(): array
    {
        return [
            self::TYPE_BRIGADE => 'Бригада',
            self::TYPE_INDIVIDUAL => 'Частный исполнитель',
        ];
    }
    public static function getLegalTypes(): array
    {
        return [
            self::LEGAL_TYPE_LEGAL => 'Частное лицо',
            self::LEGAL_TYPE_PRIVATE => 'Юридическое лицо',
            self::LEGAL_TYPE_IE => 'ИП'
        ];
    }
}

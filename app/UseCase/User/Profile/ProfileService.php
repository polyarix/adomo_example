<?php

namespace App\UseCase\User\Profile;

use App\Entity\Advert\Category;
use App\Entity\Location\District;
use App\Entity\User\Executor\WorkData;
use App\Entity\User\User;
use App\Http\Requests\Api\User\Cabinet\MainInfoRequest;
use App\Http\Requests\Api\User\Cabinet\WorkCategories\CategoryPriceRequest;

class ProfileService
{
    public function updateCategoryPrice(User $user, CategoryPriceRequest $request)
    {
        $category = Category::findOrFail($request->get('category_id'));

        $user->workData->categories()->updateExistingPivot($category, ['price' => $request->get('price')], false);
    }

    public function updateMainInfo(User $user, MainInfoRequest $request)
    {
        if($user->isExecutor()) {
            /** @var WorkData $workData */
            $workData = $user->workData;
            $workData->update([
                'brigade_size' => $request->get('brigade_size', 0),
                'about' => $request->get('about'),
            ]);

            $workData->districts()->detach();
            $data = [];
            foreach (array_unique($request->get('districts', [])) as $districtId) {
                $data[$districtId] = ['entity_id' => $user->id, 'type' => District::TYPE_USER];
            }
            $workData->districts()->attach($data);
        }

        $user->update(['about' => $request->get('about'), 'city_id' => $request->get('city')]);
    }

    public function detachCategory(User $user, int $categoryId)
    {
        if($user->isCustomer()) {
            throw new \DomainException('Категории работы могут указывать только исполнители.');
        }

        $user->workData->categories()->detach($categoryId);
    }

    public function attachCategory(User $user, int $categoryId)
    {
        if($user->isCustomer()) {
            throw new \DomainException('Категории работы могут указывать только исполнители.');
        }

        if($user->workData->categories()->where('category_id', $categoryId)->exists()) {
            return true;
        }

        if($user->workData->categories()->count() >= 2 && !$user->hasPremium()) {
            throw new \DomainException('Только премиум пользователь может иметь больше 2-х категорий в специализации.');
        }

        $user->workData->categories()->attach($categoryId, ['user_id' => $user->id]);
    }
}

<?php

namespace App\UseCase\User\Profile;

use App\Entity\Advert\Advert\Order;
use App\Entity\Advert\Advert\Photo;
use App\Entity\Advert\Advert\Service;
use App\Entity\Advert\Category;
use App\Entity\Advert\Tag;
use App\Entity\Location\District;
use App\Entity\User\User;
use App\Http\Requests\Api\User\Cabinet\Services\CreateRequest;
use App\Http\Requests\Api\User\Cabinet\Services\UpdateRequest;
use Cviebrock\EloquentSluggable\Services\SlugService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ServicesService
{
    public function getById(int $id): Service
    {
        return Service::with(['photos', 'videos', 'districts'])->findOrFail($id);
    }

    public function update(Service $service, UpdateRequest $request)
    {
        /** @var Service $service */
        $service->update([
            'title' => $title = $request->get('title'),
            'description' => $request->get('description'),
            'city_id' => $request->get('city'),
            'price' => $request->get('price'),
            'price_type' => $request->get('price_type'),
            'status' => Service::STATUS_MODERATION
        ]);

        // update photos
        $service->photos()->update(['morph_id' => null]);

        $photos = Photo::whereIn('id', $request->get('photos'))->whereNull('morph_id')->get();
        $service->photos()->saveMany($photos);

        if($videos = $request->get('videos')) {
            foreach ($videos as $url) {
                $service->videos()->updateOrCreate(['url' => $url]);
            }
        }

        $service->tags()->detach();
        if($tags = $request->get('tags')) {
            $tags = Tag::whereIn('id', $tags)->get();

            if($tags->count()) {
                $service->tags()->saveMany($tags);
            }
        }

        // update categories
        $service->categories()->detach();

        $data = [];
        foreach (array_unique($request->get('categories')) as $categoryId) {
            $data[$categoryId] = ['service_id' => $service->id];
        }
        $service->categories()->attach($data);

        // update districts
        $service->districts()->detach();

        $data = [];
        foreach (array_unique($request->get('districts')) as $districtId) {
            $data[$districtId] = ['entity_id' => $service->id, 'type' => District::TYPE_SERVICE];
        }
        $service->districts()->attach($data);

        return $service;
    }

    public function delete(Service $service)
    {
        $service->photos->map(function(Photo $photo) {
            Storage::delete($photo->path);
            $photo->delete();
        });

        $service->delete();
    }

    public function isUserOwnOfService(User $user, Service $service): bool
    {
        return $user->id === $service->user->id;
    }

    public function getAll(User $user, ?int $categoryId = null)
    {
        $query = $user->services()->orderBy('created_at', 'DESC')->with('categories');

        if($categoryId) {
            $query = $query->whereHas('categories', function(Builder $query) use($categoryId) {
                $query->where('category_id', $categoryId);
            });
        }

        $services = $query->get();

        return $services;
    }

    public function create(User $user, CreateRequest $request): Service
    {
        /** @var Service $service */
        $service = $user->services()->create([
            'title' => $title = $request->get('title'),
            'description' => $request->get('description'),
            'city_id' => $request->get('city'),
            'price' => $request->get('price'),
            'price_type' => $request->get('price_type'),
            'slug' => SlugService::createSlug(Service::class, 'slug', $title),
            'status' => Service::STATUS_MODERATION
        ]);

        $photos = Photo::whereIn('id', $request->get('photos'))->whereNull('morph_id')->get();
        $service->photos()->saveMany($photos);

        $service->videos()->delete();
        if($videos = $request->get('videos')) {
            foreach ($videos as $url) {
                $service->videos()->create(['url' => $url, 'morph_id' => $service->id, 'morph_type' => Service::class]);
            }
        }

        if($tags = $request->get('tags')) {
            $tags = Tag::whereIn('id', $tags)->get();

            if($tags->count()) {
                $service->tags()->saveMany($tags);
            }
        }

        $data = [];
        foreach (array_unique($request->get('categories')) as $categoryId) {
            $data[$categoryId] = ['service_id' => $service->id];
        }
        $service->categories()->attach($data);

        $data = [];
        foreach (array_unique($request->get('districts')) as $districtId) {
            $data[$districtId] = ['entity_id' => $service->id, 'type' => District::TYPE_SERVICE];
        }
        $service->districts()->attach($data);

        return $service;
    }

    public function getAvailableCategories(User $user)
    {
        $categoryIds = \DB::table('advert_service_categories')
            ->select('category_id')
            ->distinct()
            ->whereIn('service_id', $user->services()->select('id')->get()->pluck('id'))
            ->get()
            ->pluck('category_id');

        $categories = Category::whereIn('id', $categoryIds)->visible()->get();

        return $categories;
    }
}

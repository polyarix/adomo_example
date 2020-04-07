<?php

namespace App\UseCase\User\Profile;

use App\Entity\User\Portfolio\Photo;
use App\Entity\User\Portfolio\Album;
use App\Entity\User\User;
use App\Events\User\Cabinet\PortfolioAlbumCreated;
use App\Http\Requests\Api\Advert\Order\PhotoUploadRequest;
use App\Http\Requests\Api\User\Cabinet\Portfolio\CreateRequest;
use App\Http\Requests\Api\User\Cabinet\Portfolio\UpdateRequest;
use App\Service\Main\Upload\ImageUploader;

class PortfolioService
{
    /**
     * @var ImageUploader
     */
    private $imageUploader;

    public function __construct(ImageUploader $imageUploader)
    {
        $this->imageUploader = $imageUploader;
    }

    public function getAlbumById(int $id): Album
    {
        return Album::with(['photos', 'user', 'preview'])->findOrFail($id);
    }

    public function getAll(User $user)
    {
        return $user->albums()->orderBy('updated_at', 'DESC')->get();
    }

    public function getClosestAlbums(Album $album)
    {
        $prev = $album->user->albums()->where('updated_at', '>', $album->updated_at)->first();
        $next = $album->user->albums()->where('updated_at', '<', $album->updated_at)->first();

        return [$prev, $next];
    }

    public function isUserOwnOfAlbum(User $user, Album $album): bool
    {
        return $user->id === $album->user->id;
    }

    public function delete(Album $album)
    {
        $album->delete();
    }

    public function uploadPhoto(PhotoUploadRequest $request): Photo
    {
        $image = $request->file('file');

        $data = $this->imageUploader->upload($image, 'portfolio', Photo::MAX_ALLOWED_WIDTH);

        $photo = Photo::create([
            'path' => $data->path,
            'crop' => $data->crop,
            'album_id' => null,
        ]);

        return $photo;
    }

    public function createAlbum(User $user, CreateRequest $request): Album
    {
        $photos = Photo::whereIn('id', $request->get('photos'))->whereNull('album_id')->get();
        if($photos->count() === 0) {
            throw new \InvalidArgumentException('Unable to create album with 0 photos.');
        }

        /** @var Album $album */
        $album = $user->albums()->create([
            'title' => $title = $request->get('title'),
            'description' => $request->get('description'),
        ]);

        $album->photos()->saveMany($photos);

        if($videos = $request->get('videos')) {
            foreach ($videos as $url) {
                $album->videos()->updateOrCreate(['url' => $url]);
            }
        }

        event(new PortfolioAlbumCreated($album, $user));

        return $album;
    }

    public function updateAlbum(Album $album, UpdateRequest $request): Album
    {
        $photos = Photo::whereIn('id', $request->get('photos'))->where(function ($q) use($album) {
            $q->whereNull('album_id')->orWhere('album_id', $album->id);
        })->get();

        if($photos->count() === 0) {
            throw new \InvalidArgumentException('Unable to create album with 0 photos.');
        }

        // detach old photos
        $album->photos()->whereNotIn('id', $photos->pluck('id'))->update(['album_id' => null]);

        $album->videos()->delete();
        if($videos = $request->get('videos')) {
            foreach ($videos as $url) {
                $album->videos()->updateOrCreate(['url' => $url]);
            }
        }

        $album->update([
            'title' => $title = $request->get('title'),
            'description' => $request->get('description'),
        ]);

        $album->photos()->saveMany($photos);

        return $album;
    }
}

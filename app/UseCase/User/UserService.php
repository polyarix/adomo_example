<?php

namespace App\UseCase\User;

use App\Entity\Advert\Advert\Order;
use App\Entity\Advert\Advert\Order\Review;
use App\Entity\Advert\Advert\Service;
use App\Entity\Advert\Category;
use App\Entity\User\Executor\WorkData;
use App\Entity\User\User;
use App\Helpers\Services\Downloader\DownloaderInterface;
use Carbon\Carbon;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class UserService
{
    /**
     * @var DownloaderInterface
     */
    private $downloader;

    public function __construct(DownloaderInterface $downloader)
    {
        $this->downloader = $downloader;
    }

    public function getById(int $id): User
    {
        return User::findOrFail($id);
    }

    public function getUserWorkCategories(User $user): array
    {
        if(!$user->workData) {
            return [];
        }

        return $user->workData->categories()->withPivot('price')->get()->pluck('pivot.price', 'id')->toArray();
    }

    public function getTasks(User $user, ?string $type = null)
    {
        $query = Order::with(['user', 'executor', 'photos', 'reviews', 'category', 'requests' => function ($q) use($user) {
            $q->where('user_id', $user->id);
        }])
            ->where(function($q) use($user) {
                return $q->whereHas('requests', function($q) use($user) {
                    return $q->where('user_id', $user->id);
                })
                ->orWhere('user_id', '=', $user->id)
                ->orWhere('executor_id', '=', $user->id);
            })
            ->orderBy('updated_at', 'DESC')
        ;

        if($type) {
            if(in_array($type, [Order::STATUS_FINISHED, Order::STATUS_COMPLETED])) {
                $query->where(function($q) {
                    $q->where('status', '=', Order::STATUS_FINISHED);
                    $q->orWhere('status', '=', Order::STATUS_COMPLETED);
                });
            } else {
                $query->where('status', '=', $type, 'AND');
            }
        }

        return $query->get();
    }

    public function getUserTasks(User $user)
    {
        return $user->services()->active()->orderBy('moderated_at', 'DESC')->paginate(1);
    }

    public function getDetailTasks(User $user, ?string $type = null)
    {
        $query = Order::with(['user', 'executor', 'photos', 'reviews', 'city', 'category', 'requests' => function ($q) use($user) {
            $q->where('user_id', $user->id);
        }])
            ->where(function($q) use($user) {
                return $q->whereHas('requests', function($q) use($user) {
                    return $q->where('user_id', $user->id);
                })
                ->orWhere('user_id', '=', $user->id)
                ->orWhere('executor_id', '=', $user->id);
            })
            ->visible()
            ->orderBy('updated_at', 'DESC')
        ;

        if($type) {
            if(in_array($type, [Order::STATUS_FINISHED, Order::STATUS_COMPLETED])) {
                $query->where(function($q) {
                    $q->where('status', '=', Order::STATUS_FINISHED);
                    $q->orWhere('status', '=', Order::STATUS_COMPLETED);
                });
            } else {
                $query->where('status', '=', $type, 'AND');
            }
        }

        return $query->paginate();
    }

    public function extendPremium(User $user, $count): void
    {
        /** @var Carbon $date */
        $date = Carbon::now()->addDays($count);

        $user->setPremium($date);
    }

    public function stripPremium(User $user): void
    {
        $user->setPremium(null);
    }

    public function activate(User $user): void
    {
        $user->activate($date = Carbon::now());
        event(new Registered($user));
    }

    public function ban(User $user, Request $request): void
    {
        $banTo = Carbon::parse($request->get('to'));

        $user->ban(Carbon::now(), $banTo, $request->get('reason'));
    }

    public function unban(User $user): void
    {
        $user->unban();
    }

    public function createPreUser(string $email, string $first_name, string $type): User
    {
        $user = User::create([
            'first_name' => $first_name,
            'email' => $email,
            'password' => null,
            'verify_token' => null,
            'role' => User::ROLE_USER,
            'status' => User::STATUS_NEW,
            'type' => $type
        ]);

        event(new Registered($user));

        return $user;
    }

    public function uploadAvatar(User $user, UploadedFile $avatar): string
    {
        $fileName = uniqid() . '.' . $avatar->getClientOriginalExtension();

        if($user->hasAvatar()) {
            \Storage::delete('public/' . $user->photo);
        }

        $storage = Storage::disk('public');
        if(!$storage->exists($dir = User::STORAGE_PATH)) {
            $storage->makeDirectory($dir);
        }

        $resize_image = \Image::make($avatar->getRealPath());
        $resize_image->resize(150, 150, function($constraint) {
            $constraint->aspectRatio();
        })->save(storage_path('app/public/' . User::STORAGE_PATH . '/' . $fileName), config('cropper.quality'));

        $user->update(['photo' => User::STORAGE_PATH . '/' . $fileName]);

        return User::STORAGE_PATH . '/' . $fileName;
    }

    public function uploadSocialAvatar(User $user, string $url): string
    {
        $fileName = uniqid() . '.';

        if(preg_match('/\/.*\.(gif|jpg|jpeg|tiff|png)$/', $url, $match)) {
            // or $match[1] mb
            $fileName .= pathinfo($url, PATHINFO_EXTENSION);
        } else {
            $fileName .= 'jpg';
        }

        if($user->hasAvatar()) {
            \Storage::delete('public/' . $user->photo);
        }

        $path = storage_path('app/public/' . User::STORAGE_AVATAR_DIR . '/' . $fileName);
        $this->downloader->download($url, $path);

        $user->update(['photo' => User::STORAGE_AVATAR_DIR . '/' . $fileName]);

        return User::STORAGE_AVATAR_DIR . '/' . $fileName;
    }

    public function getAlbums(User $user, $limit = 2)
    {
        return $user->albums()->limit($limit)->orderBy('updated_at', 'DESC')->get();
    }

    public function getCertificates(User $user)
    {
        return $user->documents()->certificates()->public()->orderBy('updated_at', 'DESC')->get();
    }

    public function buildReviewsForView(User $user)
    {
        $data = [1 => 0, 2 => 0, 3 => 0, 4 => 0, 5 => 0];

        if($user->isCustomer()) {
            $avg = $user->reviews()
                ->select(['avg'])
                ->where('type', Review::TYPE_CUSTOMER)
                ->get()
                ->pluck('avg')
                ->each(function($value) use(&$data) {
                    $data[$value]++;
                });
        } else {
            $avg = $user->reviews()->selectRaw('
            ROUND(AVG(quality), 2) as quality,
            ROUND(AVG(professionalism), 2) as professionalism,
            ROUND(AVG(punctuality), 2) as punctuality
        ')->where('type', Review::TYPE_EXECUTOR)->first();

            $user->reviews()->where('type', Review::TYPE_EXECUTOR)->get()
                ->each(function (Review $review) use(&$data) {
                    $data[$review->quality]++;
                    $data[$review->professionalism]++;
                    $data[$review->punctuality]++;
                });
        }

        $totalReviewsCount = $user->isExecutor() ? $user->reviews->count() * 3 : $user->reviews->count();

        foreach ($data as $grade => $count) {
            $percent = 0;

            if($totalReviewsCount > 0 && $count > 0) {
                $percent = round($count / $totalReviewsCount * 100, 2);
            }

            $data[$grade] = ['count' => $count, 'percent' => $percent];
        }

        return ['grade' => array_reverse($data, true), 'avg' => $avg->toArray()];
    }

    public function groupWorkDataCategories($workCategories)
    {
        $parentIds = $workCategories->keys();

        $userCategories = Category::whereIn('id', $parentIds)->get()->map(function(Category $category) use($workCategories) {
            $category->children = $workCategories[$category->id];

            return $category;
        });

        return $userCategories;
    }

    public function groupCategoriesPriceList($workCategories)
    {
        $parentIds = $workCategories->keys();

        $userCategories = Category::whereIn('id', $parentIds)->get()->map(function(Category $category) use($workCategories) {
            $category->children = $workCategories[$category->id]->where('pivot.price', '>', 0);

            return $category;
        });

        return $userCategories->filter(function(Category $category) {return $category->children->count() > 0;});
    }

    public function hasByEmail(string $email): bool
    {
        return User::where('email', $email)->exists();
    }

    public function hasByPhone(string $phone): bool
    {
        return User::where('phone', $phone)->exists();
    }

    /**
     * @param User $user
     */
    public function incrementView(User $user, ?User $viewer = null): void
    {
        if($viewer && $viewer->id === $user->id) {
            return;
        }
        $user->increment('views');
    }
}

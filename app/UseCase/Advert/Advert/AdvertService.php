<?php

namespace App\UseCase\Advert\Advert;

use App\Entity\Advert\Advert\Order;
use App\Entity\Advert\Advert\Photo;
use App\Entity\Advert\Category;
use App\Entity\Advert\Tag;
use App\Entity\User\Conversation\Message;
use App\Entity\User\User;
use App\Events\Advert\Order\OrderCreated;
use App\Events\Advert\Order\OrderUpdated;
use App\Events\User\Advert\PersonalOrderCreated;
use App\Http\Requests\Api\Advert\Order\StoreRequest;
use App\Service\Main\Upload\ImageUploader;
use App\Service\Search\CategoryIndexer;
use App\Service\Search\OrderIndexer;
use App\Service\Search\ServiceIndexer;
use App\UseCase\User\Conversation\ConversationRepository;
use Carbon\Carbon;
use Cviebrock\EloquentSluggable\Services\SlugService;
use Elasticsearch\Client;
use Illuminate\Http\UploadedFile;
use Illuminate\Http\Request;

class AdvertService
{
    /**
     * @var ConversationRepository
     */
    private $conversationRepository;
    /**
     * @var ImageUploader
     */
    private $imageUploader;
    /**
     * @var Client
     */
    private $client;

    public function __construct(ConversationRepository $conversationRepository, ImageUploader $imageUploader, Client $client)
    {
        $this->conversationRepository = $conversationRepository;
        $this->imageUploader = $imageUploader;
        $this->client = $client;
    }

    public function getByUser(User $user)
    {
        return $user->orders()->displayable()->paginate(Order::LIMIT_PER_PAGE);
    }

    public function getById(int $id): Order
    {
        return Order::findOrFail($id);
    }

    public function search(string $query, ?User $user = null)
    {
        $response = $this->client->search([
            'index' => implode(',', array_filter([
                    CategoryIndexer::SEARCH_INDEX_KEY,
                    $user && $user->isExecutor()                ? OrderIndexer::SEARCH_INDEX_KEY    : null,
                    !$user || ($user && $user->isCustomer())    ? ServiceIndexer::SEARCH_INDEX_KEY  : null
                ])
            ),
            'body' => [
                'size' => 15,
                'query' => [
                    'bool' => [
                        'must' => [
                            'bool' => [
                                'should' => [
                                    [
                                        'multi_match' => [
                                            'query' => $query,
                                            'fields' => ['title^3'],
                                            'operator' => 'and'
                                        ]
                                    ],
                                    [
                                        'multi_match' => [
                                            'query' => $query,
                                            'fields' => ['title^3'],
                                            'type' => 'phrase_prefix',
                                            'operator' => 'and'
                                        ]
                                    ],
                                ],
                                'minimum_should_match' => 1
                            ]
                        ]
                    ],
                ],
                'highlight' => [
                    'fields' => [
                        'description' => new \stdClass(),
                        'title' => new \stdClass(),
                    ]
                ]
            ]
        ]);

        $data = array_map(function($el) {
            $type = $el['_type'];

            if($type === CategoryIndexer::SEARCH_INDEX_KEY) {
                $type = 'category';
            } elseif ($type === OrderIndexer::SEARCH_INDEX_KEY) {
                $type = 'order';
            } elseif ($type === ServiceIndexer::SEARCH_INDEX_KEY) {
                $type = 'service';
            }

            return ['highlight' => $el['highlight'] ?? null, 'data' => $el['_source'] ?? null, 'type' => $type];
        }, $response['hits']['hits']);

        return $data;
    }

    public function suggest(string $query, ?User $user = null)
    {
        $response = $this->client->search([
            'index' => implode(',', array_filter([
                    CategoryIndexer::SEARCH_INDEX_KEY,
                    $user && $user->isExecutor()                ? OrderIndexer::SEARCH_INDEX_KEY    : null,
                    !$user || ($user && $user->isCustomer())    ? ServiceIndexer::SEARCH_INDEX_KEY  : null
                ])
            ),
            'suggest' => [
                'my-suggestion' => [
                    'text' => $query,
                    'completion' => [
                        'field' => 'title_suggest'
                    ]
                ]
            ]
        ]);

        $data = array_map(function($el) {
            $type = $el['_type'];

            if($type === CategoryIndexer::SEARCH_INDEX_KEY) {
                $type = 'category';
            } elseif ($type === OrderIndexer::SEARCH_INDEX_KEY) {
                $type = 'order';
            } elseif ($type === ServiceIndexer::SEARCH_INDEX_KEY) {
                $type = 'service';
            }

            return ['highlight' => $el['highlight'] ?? null, 'data' => $el['_source'] ?? null, 'type' => $type];
        }, $response['suggest']['my-suggestion']);

        return $data;
    }

    public function update(StoreRequest $request, Order $order): Order
    {
        list($lat, $lng) = $request->get('coords');

        $date = Carbon::parse($request->get('date'));

        /** @var Order $order */
        $order->update([
            'title' => $title = $request->get('title'),
            'description' => $request->get('description'),
            'category_id' => $request->get('category'),
            'city_id' => $request->get('city'),
            'price' => $request->get('price'),
            'address' => $request->get('address'),
            'comment' => $request->get('comment'),
            'district_id' => $request->get('district'),
            'price_type' => $request->get('price_type'),
            'beginning_date' => $date,
            'time_type' => $request->get('time_type'),
            'map_lat' => $lat,
            'map_long' => $lng,
            'house_provision' => $request->get('house_provision', false),
            'materials_provision' => $request->get('material_provision', false),
            //'status' => Order::STATUS_MODERATION,
        ]);

        $order->tags()->detach();
        if($tags = $request->get('tags')) {
            $tags = Tag::whereIn('id', $tags)->get();

            if($tags->count()) {
                $order->tags()->saveMany($tags);
            }
        }

        // update photos
        $order->photos()->update(['morph_id' => null]);

        $photos = Photo::whereIn('id', $request->get('photos'))->whereNull('morph_id')->get();
        $order->photos()->saveMany($photos);

        event(new OrderCreated($order));

        return $order;
    }

    public function create(StoreRequest $request, User $user): Order
    {
        list($lat, $lng) = $request->get('coords');

        $date = Carbon::parse($request->get('date'));

        /** @var Order $order */
        $order = $user->orders()->create([
            'title' => $title = $request->get('title'),
            'description' => $request->get('description'),
            'category_id' => $request->get('category'),
            'city_id' => $request->get('city'),
            'user_id' => $user->id,
            'price' => $request->get('price'),
            'address' => $request->get('address'),
            'comment' => $request->get('comment'),
            'district_id' => $request->get('district'),
            'price_type' => $request->get('price_type'),
            'time_type' => $request->get('time_type'),
            'beginning_date' => $date,
            'map_lat' => $lat,
            'map_long' => $lng,
            'house_provision' => $request->get('house_provision', false),
            'materials_provision' => $request->get('material_provision', false),
            'slug' => SlugService::createSlug(Order::class, 'slug', $title),
            'status' => Order::STATUS_MODERATION,
        ]);

        if($tags = $request->get('tags')) {
            $tags = Tag::whereIn('id', $tags)->get();

            if($tags->count()) {
                $order->tags()->saveMany($tags);
            }
        }

        $photos = Photo::whereIn('id', $request->get('photos'))->whereNull('morph_id')->get();
        $order->photos()->saveMany($photos);

        /** @var User $executor */
        // if it's order for specific user
        if($request->has('executor') && ($executor = User::find($request->get('executor'))) && $executor->isExecutor()) {
            $order->moderate(Carbon::now());
            $order->update(['executor_id' => $executor->id]);

            $conversation = $this->conversationRepository->createByOrder($order);

            $conversation->messages()->create([
                'message' => $message = 'Вам предложено сотрудничество по проекту.',
                'type' => Message::TYPE_SUCCESS_NOTIFICATION,
                'user_id' => $user->id,
            ]);

            $order->requests()->create([
                'customer_invite' => true,
                'user_id' => $executor->id,
                'message' => $message = '',
            ]);

            event(new PersonalOrderCreated($order, $user, $executor));
        }

        event(new OrderUpdated($order));

        return $order;
    }

    // method for returning user adverts: services or orders, depends of authentication and user type
    public function getAdvertsList(?User $user = null, $cityId = null)
    {
        $descendantsOrders = function($q) use($cityId) {
            $q->where('is_visible', true);
            if($cityId) {
                $q->where('city_id', $cityId);
            }
        };

        $childrenFilter = function($q) use($descendantsOrders, $cityId) {
            $q->withCount([
                'orders' => $descendantsOrders,
                'descendantsServices' => function($q) use($cityId) {
                    $q->where('city_id', $cityId);
                }
            ]);
        };

        if(!$user || $user->isExecutor()) {
            return Category::defaultOrder()
                ->withCount([
                    'descendantsOrders' => function($q) use($cityId) {$q->where('is_visible', true)->where('city_id', $cityId);}
                ])
                ->with(['children'])
                //->whereHas('children')
                ->visible()
                ->withDepth()
                ->having('depth', '=', 0)
                ->get();
        }

        // return categories for customer
        return Category::defaultOrder()
            ->with(['children' => $childrenFilter])
            ->withCount(['descendantsServices' => function($q) use($cityId) {
                $q->where('is_visible', true);
                if($cityId) {
                    $q->where('city_id', $cityId);
                }
            }])
            ->visible()
            ->withDepth()
            ->having('depth', '=', 0)
            ->get()
        ;
    }

    public function uploadPhoto($request, $morphId = null)
    {
        if($request instanceof UploadedFile) {
            $image = $request;
        } else {
            /** @var Request $request */
            $image = $request->file('file');
        }

        $data = $this->imageUploader->upload($image, 'advs', Photo::MAX_ALLOWED_WIDTH);

        $photo = Photo::create([
            'path' => $data->path,
            'crop' => $data->crop,
            'morph_id' => $morphId,
            'morph_type' => Order::class
        ]);

        return $photo;
    }
}

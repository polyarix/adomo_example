<?php

namespace App\Service\Search;

use App\Entity\Advert\Advert\Order;
use Elasticsearch\Client;
use Elasticsearch\Common\Exceptions\Missing404Exception;

class OrderIndexer
{
    const SEARCH_INDEX_KEY = 'orders';

    /**
     * @var Client
     */
    private $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function clear()
    {
        $this->client->deleteByQuery([
            'index' => self::SEARCH_INDEX_KEY,
            'type' => self::SEARCH_INDEX_KEY,
            'body' => [
                'query' => [
                    'match_all' => new \stdClass(),
                ],
            ],
        ]);
    }

    public function reindex(Order $order): void
    {
        try {
            $this->remove($order);
        } catch (Missing404Exception $e) {}

        $this->index($order);
    }

    public function index(Order $order): void
    {
        $this->client->index([
            'index' => self::SEARCH_INDEX_KEY,
            'type' => self::SEARCH_INDEX_KEY,
            'id' => $order->id,
            'body' => [
                'id' => $order->id,
                'title' => $order->title,
                'title_suggest' => $order->title,
                'description' => $order->description,
                'slug' => $order->slug,
                'status' => $order->status,
                'moderated_at' => $order->moderated_at ? $order->moderated_at->format(DATE_ATOM) : null,
                'category' => $order->category->name,
                'category_id' => $order->category->id
            ],
        ]);
    }

    public function remove(Order $order): void
    {
        $this->client->delete([
            'index' => self::SEARCH_INDEX_KEY,
            'type' => self::SEARCH_INDEX_KEY,
            'id' => $order->id,
        ]);
    }
}

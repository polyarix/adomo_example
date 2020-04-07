<?php

namespace App\Service\Search;

use App\Entity\Advert\Advert\Service;
use Elasticsearch\Client;
use Elasticsearch\Common\Exceptions\Missing404Exception;

class ServiceIndexer
{
    const SEARCH_INDEX_KEY = 'services';

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

    public function reindex(Service $service): void
    {
        try {
            $this->remove($service);
        } catch (Missing404Exception $e) {}

        $this->index($service);
    }

    public function index(Service $service): void
    {
        $this->client->index([
            'index' => self::SEARCH_INDEX_KEY,
            'type' => self::SEARCH_INDEX_KEY,
            'id' => $service->id,
            'body' => [
                'id' => $service->id,
                'title' => $service->title,
                'title_suggest' => $service->title,
                'slug' => $service->slug,
                'description' => $service->description,
                'status' => $service->status,
                'moderated_at' => $service->moderated_at ? $service->moderated_at->format(DATE_ATOM) : null,
            ],
        ]);
    }

    public function remove(Service $service): void
    {
        $this->client->delete([
            'index' => self::SEARCH_INDEX_KEY,
            'type' => self::SEARCH_INDEX_KEY,
            'id' => $service->id,
        ]);
    }
}

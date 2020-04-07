<?php

namespace App\Service\Search;

use App\Entity\Advert\Category;
use Elasticsearch\Client;
use Elasticsearch\Common\Exceptions\Missing404Exception;

class CategoryIndexer
{
    const SEARCH_INDEX_KEY = 'advert_categories';

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

    public function index(Category $category): void
    {
        $this->client->index([
            'index' => self::SEARCH_INDEX_KEY,
            'type' => self::SEARCH_INDEX_KEY,
            'id' => $category->id,
            'body' => [
                'id' => $category->id,
                'title' => $category->name,
                'title_suggest' => $category->name,
                'slug' => $category->slug,
            ],
        ]);
    }

    public function reindex(Category $category): void
    {
        try {
            $this->remove($category);
        } catch (Missing404Exception $e) {}

        $this->index($category);
    }

    public function remove(Category $category): void
    {
        $this->client->delete([
            'index' => self::SEARCH_INDEX_KEY,
            'type' => self::SEARCH_INDEX_KEY,
            'id' => $category->id,
        ]);
    }
}

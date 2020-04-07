<?php

namespace App\Console\Commands\Search;

use App\Service\Search\CategoryIndexer;
use App\Service\Search\OrderIndexer;
use App\Service\Search\ServiceIndexer;
use Elasticsearch\Client;
use Elasticsearch\Common\Exceptions\Missing404Exception;
use Illuminate\Console\Command;

class InitCommand extends Command
{
    protected $signature = 'search:advert:init';
    protected $description = 'Create all needed indexes.';
    /**
     * @var Client
     */
    private $client;

    public function handle(Client $client)
    {
        $this->client = $client;

        $this->initCategoriesIndex();
        $this->initOrdersIndex();
        $this->initServicesIndex();
    }

    private function initOrdersIndex()
    {
        $this->createIndex(OrderIndexer::SEARCH_INDEX_KEY, [
            '_source' => ['enabled' => true],
            'properties' => [
                'id'            => ['type' => 'integer'],
                'title'         => ['type' => 'keyword'],
                'title_suggest' => ['type' => 'completion'],
                'slug'          => ['type' => 'text'],
                'description'   => ['type' => 'text'],
                'category'      => ['type' => 'text'],
                'category_id'   => ['type' => 'integer'],
                'tags'          => ['type' => 'text'],
                'status'        => ['type' => 'text'],
                'moderated_at'  => ['type' => 'date']
            ]
        ]);
    }

    private function initServicesIndex()
    {
        $this->createIndex(ServiceIndexer::SEARCH_INDEX_KEY, [
            '_source' => ['enabled' => true],
            'properties' => [
                'id'            => ['type' => 'integer'],
                'title'         => ['type' => 'keyword'],
                'title_suggest' => ['type' => 'completion'],
                'slug'          => ['type' => 'text'],
                'description'   => ['type' => 'text'],
                'status'        => ['type' => 'text'],
                'moderated_at'  => ['type' => 'date']
            ]
        ]);
    }

    private function initCategoriesIndex()
    {
        $this->createIndex(CategoryIndexer::SEARCH_INDEX_KEY, [
            '_source' => ['enabled' => true],
            'properties' => [
                'id'            => ['type' => 'integer'],
                'title'         => ['type' => 'keyword'],
                'title_suggest' => ['type' => 'completion'],
                'slug'          => ['type' => 'text'],
            ]
        ]);
    }

    private function createIndex(string $index, array $mapping)
    {
        try {
            $this->client->indices()->delete(['index' => $index]);
            $this->warn('Index "'.$index.'" was exists, removed.');
        } catch (Missing404Exception $e) {}

        $this->client->indices()->create([
            'index' => $index,
            'body' => [
                'mappings' => [
                    $index => $mapping,
                ],
                'settings' => [
                    'analysis' => [
                        'char_filter' => [
                            'replace' => [
                                'type' => 'mapping',
                                'mappings' => [
                                    '&=> and '
                                ],
                            ],
                        ],
                        'filter' => [
                            'word_delimiter' => [
                                'type' => 'word_delimiter',
                                'split_on_numerics' => false,
                                'split_on_case_change' => true,
                                'generate_word_parts' => true,
                                'generate_number_parts' => true,
                                'catenate_all' => true,
                                'preserve_original' => true,
                                'catenate_numbers' => true,
                            ],
                            'ru_stop' => [
                                'type' => 'stop',
                                'stopwords' => '_russian_'
                            ],
                            'ru_stemmer' => [
                                'type' => 'stemmer',
                                'language' => 'russian'
                            ],
                            'ru_RU' => [
                                'type' => 'hunspell',
                                'locale' => 'ru_RU',
                                'dedup' => true,
                            ]
                        ],
                        'analyzer' => [
                            'default' => [
                                'type' => 'custom',
                                'char_filter' => [
                                    'html_strip',
                                    'replace',
                                ],
                                'tokenizer' => 'standard',
                                'filter' => [
                                    'lowercase',
                                    'word_delimiter',
                                    'ru_stop',
                                    'ru_stemmer',
                                    'ru_RU'
                                ],
                            ],
                        ],
                    ],
                ]
            ]
        ]);

        $this->info('Index "'.$index.'" successful created.');
    }
}

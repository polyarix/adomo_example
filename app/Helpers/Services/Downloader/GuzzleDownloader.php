<?php

namespace App\Helpers\Services\Downloader;

use GuzzleHttp\Client;

class GuzzleDownloader implements DownloaderInterface
{
    /**
     * @var Client
     */
    private $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function download(string $url, string $saveTo): void
    {
        $this->client->get($url, [
            'save_to' => fopen($saveTo, 'w')
        ]);
    }
}

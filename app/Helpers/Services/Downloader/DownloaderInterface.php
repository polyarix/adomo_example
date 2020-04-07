<?php

namespace App\Helpers\Services\Downloader;

interface DownloaderInterface
{
    public function download(string $url, string $saveTo);
}

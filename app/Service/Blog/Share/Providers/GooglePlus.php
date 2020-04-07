<?php

namespace App\Service\Blog\Share\Providers;

use App\Service\Blog\Share\Providers\AbstractProvider;


class GooglePlus extends AbstractProvider
{

    protected $provider = 'gplus';

    protected $windowWidth  = 490;
    protected $windowHeight = 600;


    public function getUrl()
    {
        $url = 'https://plus.google.com/share?'
             . 'url=' . urlencode($this->getOption('url'));

        $language = $this->getOption('hl');
        if ($language) {
            $url .= '&hl=' . $language;
        }

        return $url;
    } // end getUrl

    public function getCount()
    {
        $count = $this->getCache();
        if (!is_null($count)) {
            return $count;
        }

        $url = 'https://plusone.google.com/_/+1/fastbutton?url='
             . urlencode($this->getOption('url'))
             .'&count=true';

        $result = $this->fileGetContents($url);
        preg_match('~aggregateCount[^>]+>(\d+)</div>~', $result, $matches);

        $count = isset($matches[1]) ? $matches[1] : 0;
        $this->setCache($count);

        return $count;
    } // end getCount

}


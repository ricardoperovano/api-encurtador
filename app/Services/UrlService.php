<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;

class UrlService
{
    private $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890';

    /**
     * 
     */
    public function getShortenedUrl($originalUrl)
    {
        $string = $this->getRandomString();

        //verify cache for duplicate entries
        while (Cache::has($string)) {
            $string = $this->getRandomString();
        }

        $this->cacheUrl($string, $originalUrl);

        return $string;
    }

    public function cacheUrl($shortened, $url)
    {
        Cache::put($shortened, $url, 10080);
        Cache::put($url, $shortened, 10080);
    }

    /**
     * Generate random strings
     */
    public function getRandomString($length = 6)
    {
        $string = '';
        /**
         * possible number of characters
         */
        $charactersLength = strlen($this->characters);

        for ($i = 0; $i < $length; $i++) {
            $string .= $this->characters[rand(0, $charactersLength - 1)];
        }

        return $string;
    }
}

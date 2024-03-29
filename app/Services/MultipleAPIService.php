<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class MultipleAPIService
{

    public function post($host, $key, $header_content, $url, $params)
    {
            return $response= Http::withHeaders(
            [
                'X-RapidAPI-Host' => $host,
                'X-RapidAPI-Key' => $key,
                'content-type' => $header_content
            ]
        )->post($url, $params);
//            return \GuzzleHttp\json_decode($response,true);

    }

}

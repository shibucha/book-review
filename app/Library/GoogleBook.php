<?php

namespace app\Library;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use GuzzleHttp\Client;

class GoogleBook{

    public static function googleBooksKeyword($keyword)
    {

        $keyword = urlencode($keyword);

        $url = 'https://www.googleapis.com/books/v1/volumes?q=' . $keyword . '&maxResults=30&country=JP&tbm=bks';

        $client = new Client();

        $response = $client->request("GET", $url);

        $body = $response->getBody();

        $bodyArray = json_decode($body, true);

        return $bodyArray['items'];
    }

    public static function googleBookStore(){
        
    }
}
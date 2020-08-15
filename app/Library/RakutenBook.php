<?php

namespace app\Library;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use GuzzleHttp\Client;

class RakutenBook
{
    public static function rakutenBooksIsbn($isbn)
    {

        $isbn =  urlencode($isbn);

        $url = 'https://app.rakuten.co.jp/services/api/BooksBook/Search/20170404?format=json&isbn=' . $isbn . '&sort=sales&applicationId=1040536237877869158';

        $client = new Client();

        $response = $client->request("GET", $url);

        $body = $response->getBody();

        $bodyArray = json_decode($body, true);

        return $bodyArray['Items'];
    }

    public static function rakutenBooksKeyword($keyword)
    {

        $keyword = urlencode($keyword);

        $url = 'https://app.rakuten.co.jp/services/api/BooksBook/Search/20170404?format=json&title=' . $keyword . '&sort=sales&applicationId=1040536237877869158';

        $client = new Client();

        $response = $client->request("GET", $url);

        $body = $response->getBody();

        $bodyArray = json_decode($body, true);

        return $bodyArray['Items'];
    }
}

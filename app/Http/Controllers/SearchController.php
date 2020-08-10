<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;

class SearchController extends Controller
{
    public function index(Request $request){

        $items = null;
        $keyword = $request->keyword;

        if(!empty($request->keyword)){

            $title = urlencode($request->keyword);

            $url = 'https://www.googleapis.com/books/v1/volumes?q=' . $title . '&country=JP&tbm=bks';

            $client = new Client();

            $response = $client->request('GET', $url);

            $body = $response->getBody();

            $bodyArray = json_decode($body,true);

            $items = $bodyArray['items'];

        }


        return view('books.search',[
            'items' => $items,
            'keyword' => $keyword,
        ]);
    }
}

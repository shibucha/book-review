<?php

namespace app\Library;

use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;


class BookReviewCommon
{

    public static function setPagination($items, $page, Request $request)
    {
        $items = collect($items);

        return $items = new LengthAwarePaginator(
            $items->forPage($request->page, $page),
            $items->count(),
            $page,
            $request->page,
            ['path' => $request->url()]
        );
    }
}

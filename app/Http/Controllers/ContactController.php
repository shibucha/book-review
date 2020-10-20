<?php

namespace App\Http\Controllers;

// Request
use Illuminate\Http\Request;
use App\HttP\Requests\ContactRequest;

class ContactController extends Controller
{
    public function index()
    {
        return view('contacts.index');
    }

    public function confirm(ContactRequest $request)
    {

        $data = $request->all();
        $data = (object)$data;

        if (!isset($data)) {
            return redirect()->route('contacts.index');
        }

        return view('contacts.confirm', ['data' => $data]);
    }

    public  function complete(ContactRequest $request)
    {
        $data = $request->all();
        ddd($data);
        
        return redirect()->route('contacts.index', [
            "message" => "送信完了しました！",
        ]);
    }
}

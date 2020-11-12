<?php

namespace App\Http\Controllers;

use App\Models\Public1\Lists;
use Illuminate\Http\Request;

class MainController extends Controller
{
    public function index(Request $request)
    {
        return view('index');
    }

    public function showList($slug)
    {
        $slug = Lists::where('slug', $slug)->first();

        if($slug) {
            return redirect("/list/$slug->external_id");
        }else {
            return abort('404');
        }
    }
}

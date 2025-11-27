<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TagController extends Controller
{
    public function search(Request $Request)
    {
        $q = $request->query('q');

        if (!$q){
            return response()->json();
        }

        $tags = Tag::where('name', 'like', "%{$q}%")
        ->pluck('name');

        return response()->json($tags);


    }
}

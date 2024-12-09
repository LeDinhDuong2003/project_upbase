<?php

namespace App\Http\Controllers;

use App\Jobs\FakeDataPostJob;
use Illuminate\Http\Request;

class FakeDataPostController extends Controller
{
    //
    public function fakeDataPost(Request $request){
        for ($i=0; $i < 95 ; $i++) {
            FakeDataPostJob::dispatch();
        }
        return response()->json(["message" =>"Dispatched"]);
    }
}

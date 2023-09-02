<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;


class BlockController extends Controller
{

    public function unblock(Request $request)
    {
        if (!config('block.site.active')) {
            return redirect()->route('home');
        }

        if ($request->get('password') === config('block.site.password')) {
            session(['shouldUnlock' => '1']);
            return redirect()->route('home');
        }

        return view('blocked');
    }

}

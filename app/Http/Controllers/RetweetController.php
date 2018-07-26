<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RetweetController extends Controller
{
    public function store(Request $request, $id) {
        \Auth::user()->retweet($id);
        return redirect()->back(); 
        
    }
    
    public function destroy($id) {
        \Auth::user()->unretweet($id);
    return redirect()->back(); 
        
    }
}

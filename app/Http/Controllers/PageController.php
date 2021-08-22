<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    //
    public function contact_page(){
        //
        return view('pages/contact_page');
    }

    public function show_post($id){
        // return view('pages/show_post')->with('id',$id);
        return view('pages/show_post', compact('id'));
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth', ['except' =>['upload_form', 'download']]);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    } 
    public function upload_form()
    {
        return view('upload_form');
    }
    public function download($fileName)
    {
        
        return response()->download(public_path("uploads\\$fileName"));
    }
}

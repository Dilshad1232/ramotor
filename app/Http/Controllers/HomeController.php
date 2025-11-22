<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        return view('index');
    }

    public function about()
    {
        return view('about');
    }

    public function services()
    {
        return view('services');
    }

    public function contact()
    {
        return view('contact');
    }
    public function booking()
    {
        return view('booking');
    }
    public function team()
    {
        return view('team');
    }
    public function testamonial()
    {
        return view('testamonial');
    }
    public function notFound()
    {
        return view('404');
    }
    // public function login()
    // {
    //     return view('login');
    // }
    // public function register()
    // {
    //     return view('register');
    // }
}

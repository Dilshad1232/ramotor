<?php

namespace App\Http\Controllers;

use App\Models\Service;
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
        $services = Service::all(); // DB se saare services le lo
        return view('services', compact('services')); // variable blade me bhejo
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
    public function testimonial()
    {
        return view('testimonial');
    }
    public function notFound()
    {
        return view('404');
    }

}

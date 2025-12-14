<?php

namespace App\Http\Controllers;

use App\Models\Booking;
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

    public function team()
    {
        return view('team');
    }
/*************  ✨ Windsurf Command 🌟  *************/
    /**
     * Display the testimonial page.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function testimonial()
    {
        return view('testimonial');
    }
/*******  a5b127bc-ddae-45a4-8d5c-283094e08f3a  *******/
    public function notFound()
    {
        return view('404');
    }

  
}

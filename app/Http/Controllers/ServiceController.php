<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Service;

class ServiceController extends Controller
{
    // Show Add Service form
    public function create()
    { $services = Service::latest()->get();
        return view('admin.add_services', compact('services'));
    }

    // Store service
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'icon' => 'required|string|max:50',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $imageName = time().'_'.$request->image->getClientOriginalName();
        $request->image->move(public_path('img'), $imageName);

        Service::create([
            'title' => $request->title,
            'description' => $request->description,
            'icon' => $request->icon,
            'image' => $imageName,
        ]);

        return redirect()->back()->with('success', 'Service added successfully!');
    }
    // Delete service
    public function delete($id)
{
    $service = Service::findOrFail($id);

    // Image delete
    if ($service->image && file_exists(public_path('img/'.$service->image))) {
        unlink(public_path('img/'.$service->image));
    }

    // Data delete
    $service->delete();

    return redirect()->back()->with('success', 'Service Deleted Successfully!');
}

}

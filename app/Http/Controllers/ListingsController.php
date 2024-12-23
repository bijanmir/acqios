<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use Illuminate\Http\Request;

class ListingsController extends Controller
{
    public function create()
    {
        return view('listings.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
        ]);

        $listing = new Listing();
        $listing->title = $request->title;
        $listing->description = $request->description;
        $listing->user_id = auth()->id();
        $listing->save();

        return redirect()->route('dashboard')->with('success', 'Listing created successfully!');
    }
}

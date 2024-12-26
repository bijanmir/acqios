<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ListingsController extends Controller
{

    use AuthorizesRequests;
    public function create()
    {
        return view('listings.form', [
            'listing' => null,
            'action' => route('listings.store'),
            'method' => 'POST',
        ]);
    }


    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
            'images' => 'array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $listing = new Listing();
        $listing->title = $request->title;
        $listing->description = $request->description;
        $listing->user_id = auth()->id();

        // Handle image uploads
        $images = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('listings', 'public');
                $images[] = Storage::url($path);
            }
        }
        $listing->images = json_encode($images);

        $listing->save();

        return redirect()->route('dashboard')->with('success', 'Listing created successfully!');
    }

    public function show($id)
    {
        $listing = Listing::findOrFail($id); // Fetch the listing by ID
        return view('listings.show', compact('listing')); // Pass the listing to the view
    }

    public function edit(Listing $listing)
    {
        $this->authorize('update', $listing);

        return view('listings.form', [
            'listing' => $listing,
            'action' => route('listings.update', $listing),
            'method' => 'PUT',
        ]);
    }


    public function update(Request $request, Listing $listing)
    {
        $this->authorize('update', $listing);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'images' => 'array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Handle existing images deletion if needed
        if ($request->has('delete_images')) {
            $deleteImages = json_decode($request->input('delete_images'), true);
            $currentImages = json_decode($listing->images, true) ?: [];
            $listing->images = json_encode(array_diff($currentImages, $deleteImages));
            $listing->save();
        }

        // Handle new image uploads
        $images = json_decode($listing->images, true) ?: [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('listings', 'public');
                $images[] = Storage::url($path);
            }
        }
        $validated['images'] = json_encode($images);

        $listing->update($validated);

        return redirect()->route('listings.show', $listing)->with('success', 'Listing updated successfully!');
    }


    public function destroy(Listing $listing)
    {
        // Authorize the user to delete the listing
        $this->authorize('delete', $listing);

        // If the listing has images, delete them first
        if ($listing->images) {
            $images = json_decode($listing->images, true);
            foreach ($images as $image) {
                // Assuming images are stored in the public disk
                if (Storage::disk('public')->exists('listings/' . basename($image))) {
                    Storage::disk('public')->delete('listings/' . basename($image));
                }
            }
        }

        // Delete the listing
        $listing->delete();

        // Redirect back to the dashboard or listings index with a success message
        return redirect()->route('dashboard')->with('success', 'Listing deleted successfully!');
    }

}

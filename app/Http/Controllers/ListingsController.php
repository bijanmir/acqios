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

        $listing = Listing::create([
            'title' => $request->title,
            'description' => $request->description,
            'user_id' => auth()->id(),
        ]);

        // Handle image uploads properly
        if ($request->hasFile('images')) {
            $images = [];
            foreach ($request->file('images') as $image) {
                $path = $image->store('listings', 'public');
                $images[] = '/storage/' . $path; // Ensure correct URL format
            }
            $listing->update(['images' => json_encode($images)]);
        }

        return redirect()->route('dashboard')->with('success', 'Listing created successfully!');
    }
    public function update(Request $request, Listing $listing)
    {
        $this->authorize('update', $listing);

        Log::info('🔄 Full request data:', $request->all());

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'delete_images' => 'nullable|string', // Accept it as a string first
        ]);

        Log::info('✅ Validation passed.');

        // Update title and description
        $listing->title = $request->title;
        $listing->description = $request->description;

        // ✅ Retrieve existing images & ensure it's an array
        $existingImages = json_decode($listing->images, true) ?? [];
        $existingImages = is_array($existingImages) ? $existingImages : [];

        // ✅ Remove Selected Images
        $deleteImages = !empty($request->delete_images) ? json_decode($request->delete_images, true) : [];
        $deleteImages = is_array($deleteImages) ? $deleteImages : [];

        if (!empty($deleteImages)) {
            $existingImages = array_values(array_filter($existingImages, function ($image) use ($deleteImages) {
                return !in_array($image, $deleteImages);
            }));

            foreach ($deleteImages as $image) {
                $path = str_replace('/storage/', '', $image);
                Storage::disk('public')->delete($path);
            }
        }

        // ✅ Handle New Image Uploads
        if ($request->hasFile('images')) {
            Log::info('📸 New images detected.');

            foreach ($request->file('images') as $image) {
                $path = $image->store('listings', 'public');
                $existingImages[] = '/storage/' . $path;
            }
        } else {
            Log::info('🚫 No new images uploaded.');
        }

        // ✅ Save updated image array to database
        if (!empty($existingImages)) {
            Log::info('✅ Final saved images:', ['images' => $existingImages]);
            $listing->images = json_encode($existingImages);
        } else {
            Log::info('🚫 No images left, setting to NULL.');
            $listing->images = null;
        }

        // ✅ Save listing with new title and description
        $listing->save();

        return redirect()->route('listings.show', $listing)->with('success', 'Listing updated successfully!');
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

    public function destroy(Listing $listing)
    {
        $this->authorize('delete', $listing);

        // Decode images JSON properly
        $images = is_array($listing->images) ? $listing->images : json_decode($listing->images, true);
        $images = is_array($images) ? $images : []; // Ensure it's an array

        // If the listing has images, delete them from storage
        if (!empty($images)) {
            foreach ($images as $image) {
                $imagePath = str_replace('/storage/', '', $image); // Adjust path for storage deletion
                if (Storage::disk('public')->exists($imagePath)) {
                    Storage::disk('public')->delete($imagePath);
                }
            }
        }

        // Delete the listing from database
        $listing->delete();

        // Redirect to dashboard with success message
        return redirect()->route('dashboard')->with('success', 'Listing deleted successfully!');
    }
}

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
            'street' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'state' => 'nullable|string|max:255',
            'zip_code' => 'nullable|string|max:10',
            'country' => 'nullable|string|max:255',
            'images' => 'array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $listing = Listing::create($request->only(['title', 'description']));
        $listing->user_id = auth()->id();
        $listing->save();

        $listing->address()->create($request->only(['street', 'city', 'state', 'zip_code', 'country']));

        return redirect()->route('dashboard')->with('success', 'Listing created successfully!');
    }

    public function update(Request $request, Listing $listing)
    {
        $this->authorize('update', $listing);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'images' => 'array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'street' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'state' => 'nullable|string|max:255',
            'zip_code' => 'nullable|string|max:10',
            'country' => 'nullable|string|max:255',
        ]);

        $listing->update($validated);

        // Check if at least one address field is provided
        $addressFields = $request->only(['street', 'city', 'state', 'zip_code', 'country']);
        $hasAddressData = array_filter($addressFields); // Remove empty fields

        if (!empty($hasAddressData)) {
            // Update or create address with the provided fields
            $listing->address()->updateOrCreate([], $addressFields);
        } else {
            // If no valid address fields, delete the address if it exists
            $listing->address()->delete();
        }

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

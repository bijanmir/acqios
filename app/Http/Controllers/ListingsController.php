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
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
            'sections' => 'nullable|array',
            'sections.*.title' => 'nullable|string|max:255',
            'sections.*.description' => 'nullable|string|max:2000',
            'images' => 'array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $listing = Listing::create([
            'title' => $request->title,
            'description' => $request->description,
            'user_id' => auth()->id(),
            'sections' => json_encode($request->sections ?? []), // Store sections as JSON
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

        Log::info('📝 Store Method: Incoming Sections Data:', $request->sections ?? []);

        return redirect()->route('dashboard')->with('success', 'Listing created successfully!');
    }

    public function update(Request $request, Listing $listing)
    {
        $this->authorize('update', $listing);

        Log::info('🔍 Full Request Data:', $request->all());

        // Validate request
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'delete_images' => 'nullable|string',
            'deleted_sections' => 'nullable|string',
            'sections' => 'nullable|array',
            'sections.*.id' => 'sometimes|string', // ✅ Optional ID field for updates
            'sections.*.title' => 'required|string|max:255',
            'sections.*.description' => 'required|string|max:2000',
        ]);

        Log::info('📌 Validated Sections:', ['sections' => $validated['sections']]);

        // Retrieve existing sections as an associative array (UUID as keys)
        $existingSections = json_decode($listing->sections, true) ?? [];
        $existingSections = collect($existingSections)->keyBy('id')->toArray(); // ✅ Ensures UUID-based keys

        Log::info('🔄 Existing Sections Before Changes:', ['sections' => $existingSections]);

        // Handle Section Removal
        if ($request->has('deleted_sections')) {
            $deletedSections = json_decode($request->deleted_sections, true) ?? [];
            foreach ($deletedSections as $deletedId) {
                unset($existingSections[$deletedId]); // ✅ Removes deleted sections
            }
            Log::info('🚫 Removed Sections:', ['deleted_sections' => $deletedSections]);
        }

        // Merge new and updated sections (Preserve UUIDs, avoid duplication)
        foreach ($validated['sections'] as $uuid => $section) {
            if (isset($existingSections[$uuid])) {
                // ✅ Update existing section
                $existingSections[$uuid]['title'] = $section['title'];
                $existingSections[$uuid]['description'] = $section['description'];
            } else {
                // ✅ Add new section with a unique UUID
                $existingSections[$uuid] = array_merge(['id' => $uuid], $section);
            }
        }

        Log::info('🔄 Sections Before Saving:', ['sections' => $existingSections]);

        // Ensure JSON is stored correctly in MySQL
        $finalSections = json_encode(array_values($existingSections), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

        if (empty($existingSections)) {
            $finalSections = json_encode([]); // ✅ Prevents NULL storage
        }

        // Update listing
        $listing->update([
            'title' => $request->title,
            'description' => $request->description,
            'sections' => $finalSections, // ✅ Save as JSON
        ]);

        Log::info('✅ Sections Saved:', ['sections' => json_decode($listing->sections, true)]);

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

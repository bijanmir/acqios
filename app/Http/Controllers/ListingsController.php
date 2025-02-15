<?php

namespace App\Http\Controllers;

use App\Mail\ContactOwnerMail;
use App\Models\Listing;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;

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
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'You must be logged in to create a listing.');
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
            'sections' => 'nullable|array',
            'sections.*.title' => 'nullable|string|max:255',
            'sections.*.description' => 'nullable|string|max:2000',
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'category' => 'nullable|string|max:255',
            'location' => 'nullable|string|max:255',
            'price' => 'nullable|numeric',
            'revenue' => 'nullable|numeric',
            'profit' => 'nullable|numeric',
            'contact_email' => 'nullable|string|max:255',
            'phone_number' => 'nullable|string|max:255',
            'website' => 'nullable|string|max:255',
        ]);

        $listing = Listing::create([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'user_id' => auth()->id(),
            'sections' => empty($validated['sections']) ? json_encode([]) : json_encode($validated['sections']),
            'category' => $validated['category'] ?? null,
            'location' => $validated['location'] ?? null,
            'price' => $validated['price'] ?? null,
            'revenue' => $validated['revenue'] ?? null,
            'profit' => $validated['profit'] ?? null,
            'contact_email' => $validated['contact_email'] ?? null,
            'phone_number' => $validated['phone_number'] ?? null,
            'website' => $validated['website'] ?? null,
        ]);

        // Handle image uploads properly
        if ($request->hasFile('images')) {
            $images = [];
            foreach ($request->file('images') as $image) {
                $path = $image->store('listings', 'public');
                $images[] = '/storage/' . $path;
            }
            $listing->update(['images' => json_encode($images)]);
        }

        Log::info('📝 Store Method: Successfully Created Listing', ['listing' => $listing]);

        return redirect()->route('listings.show', $listing)->with('success', 'Listing created successfully!');
    }



    public function update(Request $request, Listing $listing)
    {
        $this->authorize('update', $listing);

        Log::info('🔍 Full Request Data:', $request->all());

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'delete_images' => 'nullable|string',
            'deleted_sections' => 'nullable|string',
            'sections' => 'nullable|array',
            'sections.*.id' => 'sometimes|string',
            'sections.*.title' => 'required|string|max:255',
            'sections.*.description' => 'required|string|max:2000',
        ]);

        // ✅ **Handle Image Deletions**
        if ($request->filled('delete_images')) {
            $deleteImages = json_decode($request->delete_images, true) ?? [];
            $existingImages = json_decode($listing->images, true) ?? [];

            $existingImages = array_filter($existingImages, function ($image) use ($deleteImages) {
                if (in_array($image, $deleteImages)) {
                    Storage::disk('public')->delete(str_replace('/storage/', '', $image));
                    return false;
                }
                return true;
            });

            $listing->update(['images' => empty($existingImages) ? null : json_encode(array_values($existingImages))]);
        }

        // ✅ **Process New Image Uploads**
        if ($request->hasFile('images')) {
            $images = json_decode($listing->images, true) ?? [];

            foreach ($request->file('images') as $image) {
                $path = $image->store('listings', 'public');
                $images[] = '/storage/' . $path;
            }

            $listing->update(['images' => json_encode($images)]);
        }

        // ✅ **Handle Sections Properly**
        $existingSections = json_decode($listing->sections, true) ?? [];
        $existingSections = collect($existingSections)->keyBy('id')->toArray();

        Log::info('🔄 Existing Sections Before Changes:', ['sections' => $existingSections]);

        // Remove deleted sections
        if ($request->filled('deleted_sections')) {
            $deletedSections = json_decode($request->deleted_sections, true) ?? [];
            foreach ($deletedSections as $deletedId) {
                unset($existingSections[$deletedId]);
            }
        }

        // Remove empty sections (fixing issue where empty ones still get saved)
        $existingSections = array_filter($existingSections, function ($section) {
            return !empty($section['title']) || !empty($section['description']);
        });

        // ✅ **Update Listing**
        $listing->update([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'sections' => empty($existingSections) ? null : json_encode(array_values($existingSections)),
        ]);

        Log::info('✅ Sections & Images Saved:', [
            'sections' => json_decode($listing->sections, true),
            'images' => json_decode($listing->images, true),
        ]);

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

    public function index(Request $request)
    {
        $query = Listing::query();

        // 🔍 Search Query
        if ($request->filled('search')) {
            $query->where('title', 'LIKE', '%' . $request->search . '%')
                ->orWhere('description', 'LIKE', '%' . $request->search . '%')
                ->orWhere('location', 'LIKE', '%' . $request->search . '%');
        }

        // 🏷️ Filter by Category
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        // 💰 Filter by Price Range
        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }
        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        switch ($request->sort) {
            case 'latest':
                $query->orderBy('created_at', 'desc');
                break;
            case 'oldest':
                $query->orderBy('created_at', 'asc');
                break;
            case 'price_low':
                $query->orderBy('price', 'asc');
                break;
            case 'price_high':
                $query->orderBy('price', 'desc');
                break;
            default:
                $query->orderBy('created_at', 'desc');
                break;
        }

        // Fetch Listings
        $listings = $query->latest()->get();
        $categories = Listing::distinct()->pluck('category');

        return view('listings.index', compact('listings', 'categories'));
    }


    public function contactOwner(Request $request, Listing $listing): \Illuminate\Http\RedirectResponse
    {
        $sender = auth()->user();

        Log::info("The email is {$listing->user->email} !");



        if (!$sender) {
            return back()->with('error', 'You must be logged in to send a message.');
        }

        try {
            Mail::to($listing->user->email)->send(new ContactOwnerMail($listing, $sender));
            return back()->with('success', 'Your message has been sent to the listing owner.');
        } catch (\Exception $e) {
            Log::error('Email sending failed: ' . $e->getMessage());
            return back()->with('error', 'There was an error sending your message. Please try again.');
        }
    }

}

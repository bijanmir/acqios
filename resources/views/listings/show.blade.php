<x-app-layout
    :ogTitle="$listing->title"
    :ogDescription="$listing->description ?? 'Check out this listing!'"
    :ogImage="!empty($images = json_decode($listing->images, true)) ? asset(reset($images)) : asset('default-preview.jpg')"
>

    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between space-y-3 sm:space-y-0">
            <div class="flex flex-col sm:flex-row sm:items-center sm:space-x-3 w-full">
                <div class="flex flex-col md:flex-row justify-center items-center space-y-2 md:space-y-0 md:space-x-4">
                    <h2 class="text-3xl text-center font-bold text-gray-900 dark:text-white">
                        {{ $listing->title }}
                    </h2>
                    @if($listing->is_verified)
                        <span class="flex items-center bg-green-100 dark:bg-green-900/40 border border-green-200 dark:border-green-800/50 px-3 py-1 rounded-full shadow-sm">
                            <svg class="w-4 h-4 mr-2 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            <span class="text-sm font-medium text-green-800 dark:text-green-300">Verified</span>
                        </span>
                    @endif
                </div>
            </div>

            <div class="hidden md:flex items-center space-x-4">
                @auth
                    @if(auth()->user()->id === $listing->user_id)
                        <!-- Edit Button for Listing Owner -->
                        <a href="{{ route('listings.edit', $listing) }}">
                            <x-button text="Edit Listing" color="indigo" icon="fa-edit" />
                        </a>
                        <!-- Delete Button -->
                        <x-button
                            text="Delete"
                            color="red"
                            icon="fa-trash"
                            onclick="openDeleteModal()"
                        />
                    @else
                        <!-- Message Owner Button -->
                        <x-button text="Message Owner" onclick="openModal()" color="indigo" icon="fa-envelope" />

                        <!-- Favorite/Unfavorite Button -->
                        <form method="POST" action="{{ route('listings.toggleFavorite', $listing->id) }}">
                            @csrf
                            @php
                                $isFavorited = auth()->user()->savedListings->contains($listing->id);
                            @endphp
                            <x-button
                                type="submit"
                                color="{{ $isFavorited ? 'green' : 'blue' }}"
                                text="{{ $isFavorited ? 'Saved' : 'Save Listing' }}"
                                icon="{{ $isFavorited ? 'fa-heart' : 'fa-heart-o' }}"
                            />
                        </form>
                    @endif
                @else
                    <!-- Login to Contact Button -->
                    <x-button
                        href="{{ route('login') }}"
                        color="indigo"
                        text="Login to Contact"
                        icon="fa-arrow-right"
                        iconPosition="right"
                    />

                    <!-- Login to Save Button -->
                    <x-button
                        href="{{ route('login') }}"
                        color="gray"
                        text="Login to Save"
                        icon="fa-heart"
                    />
                @endauth
            </div>
        </div>
    </x-slot>

    <!-- Main Content -->
    <div class="md:py-6 max-w-7xl mx-auto space-y-6">
        <div class="bg-white dark:bg-gray-800 shadow-lg md:rounded-2xl p-3 md:p-8 border border-gray-200 dark:border-gray-700">
            <!-- Image Gallery -->
            @if(!empty($listing->images))
                @php
                    $images = is_array($listing->images) ? $listing->images : json_decode($listing->images, true);
                    $images = is_array($images) ? $images : [];
                @endphp
                <div class="mb-8">
                    @if(count($images) == 1)
                        <!-- Single Image Display - Centered -->
                        @foreach($images as $image)
                            @if(is_string($image) && !empty($image))
                                <div class="flex justify-center">
                                    <div class="w-full max-w-3xl rounded-xl overflow-hidden shadow-lg">
                                        <img src="{{ asset($image) }}"
                                             alt="Listing Image"
                                             class="w-full aspect-square object-cover">
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    @else
                        <!-- Multiple Images Gallery - Carousel -->
                        <div class="relative">
                            <div class="flex justify-center">
                                <div class="w-full max-w-4xl overflow-hidden">
                                    <div class="flex snap-x snap-mandatory overflow-x-auto scrollbar-hide pb-4">
                                        @foreach($images as $image)
                                            @if(is_string($image) && !empty($image))
                                                <div class="snap-center min-w-full flex justify-center px-2">
                                                    <div class="w-full max-w-3xl rounded-xl overflow-hidden shadow-lg">
                                                        <img src="{{ asset($image) }}"
                                                             alt="Listing Image"
                                                             class="w-full aspect-square object-cover">
                                                    </div>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>

                                    @if(count($images) > 1)
                                        <!-- Navigation dots -->
                                        <div class="flex justify-center mt-4 space-x-2">
                                            @foreach($images as $index => $image)
                                                @if(is_string($image) && !empty($image))
                                                    <span class="w-2 h-2 rounded-full bg-gray-300 dark:bg-gray-600"></span>
                                                @endif
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            @endif

            <!-- Business Details -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                @foreach (['title' => 'Company Name','category' => 'Category', 'location' => 'Location'] as $key => $label)
                    <div class="bg-gray-100 dark:bg-gray-700 rounded-lg p-4 shadow-sm border border-gray-200 dark:border-gray-700">
                        <label class="block text-sm font-medium text-gray-600 dark:text-gray-300">{{ $label }}</label>
                        <p class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                            {{ $listing->$key ?? 'N/A' }}
                        </p>
                    </div>
                @endforeach
            </div>

            <!-- Listing Details -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                @foreach (['price' => 'Price', 'revenue' => 'Revenue', 'profit' => 'Profit'] as $key => $label)
                    <div class="bg-gray-100 dark:bg-gray-700 rounded-lg p-4 shadow-sm border border-gray-200 dark:border-gray-700">
                        <label class="block text-sm font-medium text-gray-600 dark:text-gray-300">{{ $label }}</label>
                        <p class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                            {{ $listing->$key ? '$' . number_format($listing->$key, 2) : 'N/A' }}
                        </p>
                    </div>
                @endforeach
            </div>

            <!-- Contact Details -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                @foreach (['contact_email' => 'Contact Email', 'phone_number' => 'Phone Number', 'website' => 'Website'] as $key => $label)
                    <div class="bg-gray-100 dark:bg-gray-700 rounded-lg p-4 shadow-sm border border-gray-200 dark:border-gray-700">
                        <label class="block text-sm font-medium text-gray-600 dark:text-gray-300">{{ $label }}</label>

                        @if(auth()->check() && (auth()->user()->id === $listing->user_id || auth()->user()->isPremium()))
                            <!-- User is either the owner or a premium user - show actual contact details -->
                            <p class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                                @if($key === 'website' && $listing->$key)
                                    <a href="{{ $listing->$key }}" class="text-blue-600 hover:underline dark:text-blue-400" target="_blank">
                                        {{ $listing->$key }}
                                    </a>
                                @else
                                    {{ $listing->$key ?? 'N/A' }}
                                @endif
                            </p>
                        @elseif(auth()->check())
                            <!-- User is logged in but not premium or the owner -->
                            <div class="flex flex-col space-y-2">
                                <p class="text-gray-500 dark:text-gray-400 italic">
                                    <span class="flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                        </svg>
                                        Upgrade to premium to view
                                    </span>
                                </p>
                                <a href="{{ route('premium.upgrade') }}" class="text-sm text-indigo-600 hover:text-indigo-800 dark:text-indigo-400 dark:hover:text-indigo-300 font-medium">
                                    Upgrade Now →
                                </a>
                            </div>
                        @else
                            <!-- User is not logged in -->
                            <div class="flex flex-col space-y-2">
                                <p class="text-gray-500 dark:text-gray-400 italic">
                                    <span class="flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                        </svg>
                                        Login to view contact details
                                    </span>
                                </p>
                                <a href="{{ route('login') }}" class="text-sm text-indigo-600 hover:text-indigo-800 dark:text-indigo-400 dark:hover:text-indigo-300 font-medium">
                                    Login Now →
                                </a>
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>

            <!-- Premium Banner (if applicable) -->
            @auth
                @if(!auth()->user()->isPremium() && auth()->user()->id !== $listing->user_id)
                    <div class="bg-gradient-to-r from-indigo-500 to-purple-600 text-white p-6 rounded-xl shadow-lg mb-8 border border-indigo-600">
                        <div class="flex flex-col md:flex-row items-center justify-between">
                            <div class="flex-1 mb-4 md:mb-0">
                                <h3 class="text-xl font-bold mb-2">✨ Unlock Premium Benefits</h3>
                                <p class="text-indigo-100">Get full access to contact details, advanced analytics, and premium listings.</p>
                            </div>
                            <div>
                                <a href="{{ route('premium.upgrade') }}" class="inline-block bg-white text-indigo-600 hover:bg-indigo-50 font-medium px-6 py-3 rounded-lg transition-colors duration-200">
                                    Upgrade to Premium
                                </a>
                            </div>
                        </div>
                    </div>
                @endif
            @endauth

            <!-- Description Section -->
            <div class="mb-8">
                <h3 class="text-2xl font-semibold text-gray-900 dark:text-gray-100 mb-4">Description</h3>
                <div class="p-6 bg-gray-50 dark:bg-gray-800 rounded-lg shadow-md border border-gray-200 dark:border-gray-700">
                    <p class="text-gray-600 dark:text-gray-300 whitespace-pre-line">
                        {{ $listing->description ?? 'No description provided.' }}
                    </p>
                </div>
            </div>

            <!-- Business Sections -->
            <div class="mb-8">
                @php
                    $sections = json_decode($listing->sections ?? '[]', true) ?? [];
                @endphp
                @if (!empty($sections))
                    <h3 class="text-2xl font-semibold text-gray-900 dark:text-gray-100 mb-4">Business Sections</h3>
                    @foreach ($sections as $section)
                        <div class="mt-4 p-6 bg-gray-50 dark:bg-gray-800 rounded-lg shadow-md border border-gray-200 dark:border-gray-700">
                            <h4 class="text-lg font-bold text-gray-900 dark:text-gray-100">{{ $section['title'] ?? 'Untitled Section' }}</h4>
                            <p class="text-gray-600 dark:text-gray-300 mt-2">{{ $section['description'] ?? 'No description available.' }}</p>
                        </div>
                    @endforeach
                @else
                    <div id="no-sections"></div>
                @endif
            </div>

            <!-- Business Location Map -->
            <div class="mb-8">
                <h3 class="text-2xl font-semibold text-gray-900 dark:text-gray-100 mb-4">Business Location</h3>
                <div class="p-6 bg-gray-50 dark:bg-gray-800 rounded-lg shadow-md border border-gray-200 dark:border-gray-700 relative">
                    <div id="map" class="w-full h-96 rounded-lg overflow-hidden"></div>
                    @if($listing->location)
                        <div class="mt-4 text-gray-600 dark:text-gray-300">
                            <p><strong>Address:</strong> {{ $listing->location }}</p>
                            <a href="https://www.google.com/maps/search/?api=1&query={{ urlencode($listing->location) }}" target="_blank" class="text-blue-600 hover:underline dark:text-blue-400">View larger map</a>
                        </div>
                    @else
                        <p class="text-gray-600 dark:text-gray-300">Location not provided.</p>
                    @endif
                </div>
            </div>

            <!-- Timestamps -->
            <div class="text-sm text-gray-500 dark:text-gray-400 my-6">
                <!-- Mobile layout (stacked) -->
                <div class="md:hidden space-y-2 p-3 bg-gray-50 dark:bg-gray-800 rounded-lg">
                    <p class="flex items-center text-gray-600 dark:text-gray-300">
                        <span class="mr-2">👀</span> Views: <strong class="ml-1">{{ $listing->views }}</strong>
                    </p>
                    <p class="flex items-center">
                        <span class="mr-2">📅</span> Created: <span class="ml-1">{{ $listing->created_at->format('M d, Y') }}</span>
                    </p>
                    <p class="flex items-center">
                        <span class="mr-2">🕒</span> Updated: <span class="ml-1">{{ $listing->updated_at->format('M d, Y') }}</span>
                    </p>
                </div>

                <!-- Desktop layout (horizontal) -->
                <div class="hidden md:flex justify-between items-center p-3 bg-gray-50 dark:bg-gray-800 rounded-lg">
                    <p class="text-gray-600 dark:text-gray-300">
                        <span>👀</span> Views <strong>{{ $listing->views }}</strong>
                    </p>
                    <p>
                        <span>📅</span> Created: {{ $listing->created_at->format('M d, Y') }}
                    </p>
                    <p>
                        <span>🕒</span> Updated: {{ $listing->updated_at->format('M d, Y') }}
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Mobile Action Buttons -->
    <div class="fixed bottom-0 z-10 w-full bg-white dark:bg-gray-900 border-t dark:border-gray-800 md:hidden shadow-lg">
        <div class="max-w-lg mx-auto px-4 py-3">
            @auth
                @if(auth()->user()->id === $listing->user_id)
                    <!-- Owner Actions -->
                    <div class="flex space-x-3">
                        <a href="{{ route('listings.edit', $listing) }}" class="flex-1 flex justify-center items-center px-4 py-3 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 font-medium transition duration-200">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                            Edit
                        </a>
                        <button onclick="openDeleteModal()" class="flex-1 flex justify-center items-center px-4 py-3 bg-red-600 text-white rounded-lg hover:bg-red-700 font-medium transition duration-200">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                            Delete
                        </button>
                    </div>
                @elseif(auth()->user()->isPremium())
                    <!-- Premium User Actions -->
                    <div class="flex space-x-3">
                        <button onclick="openModal()" class="flex-1 flex justify-center items-center px-4 py-3 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 font-medium transition duration-200">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                            Message Owner
                        </button>
                        <form method="POST" action="{{ route('listings.toggleFavorite', $listing->id) }}" class="flex-1">
                            @csrf
                            @php
                                $isFavorited = auth()->user()->savedListings->contains($listing->id);
                            @endphp
                            <button type="submit" class="w-full flex justify-center items-center px-4 py-3 rounded-lg font-medium transition duration-200
                            {{ $isFavorited
                                ? 'bg-gray-100 text-gray-800 hover:bg-gray-200 dark:bg-gray-800 dark:text-gray-200 dark:hover:bg-gray-700'
                                : 'bg-gray-100 text-gray-800 hover:bg-gray-200 dark:bg-gray-800 dark:text-gray-200 dark:hover:bg-gray-700' }}">
                                <i class="fa {{ $isFavorited ? 'fa-heart' : 'fa-heart-o' }} mr-2"></i>
                                {{ $isFavorited ? 'Saved' : 'Save' }}
                            </button>
                        </form>
                    </div>
                @else
                    <!-- Regular User Actions -->
                    <div class="space-y-3">
                        <button onclick="openModal()" class="w-full flex justify-center items-center px-4 py-3 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 font-medium transition duration-200">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                            Message Owner
                        </button>
                        <a href="{{ route('premium.upgrade') }}" class="w-full flex justify-center items-center px-4 py-2 bg-gradient-to-r from-purple-600 to-indigo-600 text-white rounded-lg hover:from-purple-700 hover:to-indigo-700 text-sm font-medium transition duration-200">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" />
                            </svg>
                            Upgrade to Premium for Contact Details
                        </a>
                    </div>
                @endif
            @else
                <!-- Guest Actions -->
                <div class="space-y-3">
                    <a href="{{ route('login') }}" class="w-full flex justify-center items-center px-4 py-3 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 font-medium transition duration-200">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                        </svg>
                        Login to Contact
                    </a>
                    <a href="{{ route('register') }}" class="w-full flex justify-center items-center px-4 py-2 bg-gray-100 text-gray-800 rounded-lg hover:bg-gray-200 text-sm font-medium transition duration-200 dark:bg-gray-800 dark:text-gray-200 dark:hover:bg-gray-700">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                        </svg>
                        Create Account
                    </a>
                </div>
            @endauth
        </div>
    </div>

    <!-- Delete Modal -->
    <div id="deleteModal" class="fixed inset-0 bg-black bg-opacity-60 backdrop-blur-sm flex justify-center items-center hidden z-50 transition-opacity duration-300">
        <div class="bg-white dark:bg-gray-900 p-6 rounded-xl shadow-2xl max-w-md w-full border border-gray-200 dark:border-gray-700 transform transition-all duration-300 scale-95">
            <div class="text-center">
                <div class="flex items-center justify-center w-12 h-12 mx-auto bg-red-100 rounded-full mb-4">
                    <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">Delete Listing</h3>
                <p class="text-sm text-gray-500 dark:text-gray-400 mb-6">
                    Are you sure you want to delete this listing? This action cannot be undone.
                </p>
            </div>

            <div class="flex justify-center space-x-4">
                <button type="button" onclick="closeDeleteModal()" class="px-4 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 dark:bg-gray-700 dark:text-gray-200 dark:hover:bg-gray-600 transition">
                    Cancel
                </button>

                <form action="{{ route('listings.destroy', $listing) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition">
                        Delete Permanently
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Include the Contact Modal Component -->
    <x-contact-modal :listing="$listing" />

    <!-- Google Maps Script -->
    <script async defer src="https://maps.googleapis.com/maps/api/js?key={{ config('services.google_maps.key') }}&libraries=places,marker&callback=initMap"></script>

    <script>
        function initMap() {
            @if($listing->location)
            // Geocode the location to get coordinates
            const geocoder = new google.maps.Geocoder();
            geocoder.geocode({ address: '{{$listing->location }}' }, (results, status) => {
                if (status === 'OK' && results[0]) {
                    const map = new google.maps.Map(document.getElementById('map'), {
                        center: results[0].geometry.location,
                        zoom: 12,
                        styles: [
                            { featureType: "poi", elementType: "labels", stylers: [{ visibility: "off" }] }, // Hide points of interest
                            { featureType: "road", elementType: "labels", stylers: [{ visibility: "off" }] }, // Hide road labels
                        ],
                        disableDefaultUI: true, // Hide default controls
                    });

                    new google.maps.Marker({
                        position: results[0].geometry.location,
                        map: map,
                        title: '{{ $listing->title }}',
                    });

                } else {
                    console.error('Geocode was not successful for the following reason: ' + status);
                    document.getElementById('map').innerHTML = '<p class="text-gray-600 dark:text-gray-300">Unable to load map for this location.</p>';
                }
            });
            @else
            document.getElementById('map').innerHTML = '<p class="text-gray-600 dark:text-gray-300">No location data available.</p>';
            @endif
        }

        function openModal() {
            const modal = document.getElementById('contactModal');
            if (modal) {
                modal.classList.remove('hidden');
                setTimeout(() => modal.querySelector('div').classList.remove('scale-95'), 10);
            }
        }

        function closeModal() {
            const modal = document.getElementById('contactModal');
            if (modal) {
                modal.querySelector('div').classList.add('scale-95');
                setTimeout(() => modal.classList.add('hidden'), 200);
            }
        }

        function openDeleteModal() {
            const modal = document.getElementById('deleteModal');
            if (modal) {
                modal.classList.remove('hidden');
                setTimeout(() => modal.querySelector('div').classList.remove('scale-95'), 10);
            }
        }

        function closeDeleteModal() {
            const modal = document.getElementById('deleteModal');
            if (modal) {
                modal.querySelector('div').classList.add('scale-95');
                setTimeout(() => modal.classList.add('hidden'), 200);
            }
        }

        // Setup event listeners
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('contactModal')?.addEventListener('click', function(e) {
                if (e.target === this) closeModal();
            });

            document.getElementById('deleteModal')?.addEventListener('click', function(e) {
                if (e.target === this) closeDeleteModal();
            });
        });
    </script>
</x-app-layout>

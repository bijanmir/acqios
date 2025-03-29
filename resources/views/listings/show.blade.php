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
                        <span class="flex items-center bg-gray-100 dark:bg-gray-800 border border-gray-200 dark:border-gray-600 px-3 py-1 rounded-full shadow-sm">
                            <img class="w-4 h-4 mr-2" src="https://img.icons8.com/emoji/48/check-mark-emoji.png" alt="check-mark-emoji"/>
                            <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Verified</span>
                        </span>
                    @endif
                </div>
            </div>

            <div class="hidden md:flex items-center space-x-4">
                @auth
                    @if(auth()->user()->id === $listing->user_id)
                        <!-- Edit Button for Listing Owner -->
                        <a href="{{ route('listings.edit', $listing) }}">
                            <x-button text="Edit Listing ✏️" color="indigo" />
                        </a>
                    @else
                        <!-- Message Owner Button -->
                        <x-button text="Message Owner  ✉️" onclick="openModal()" color="indigo" />

                        <!-- Favorite/Unfavorite Button -->
                        <form method="POST" action="{{ route('listings.toggleFavorite', $listing->id) }}">
                            @csrf
                            @php
                                $isFavorited = auth()->user()->savedListings->contains($listing->id);
                            @endphp
                            <x-button
                                type="submit"
                                color="{{ $isFavorited ? 'green' : 'blue' }}"
                                text="{{ $isFavorited ? 'Saved 🔒' : 'Save Listing  🔓' }}"
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
                    <div class="flex overflow-x-auto space-x-4 pb-4 snap-x snap-mandatory">
                        @foreach($images as $image)
                            @if(is_string($image) && !empty($image))
                                <img src="{{ asset($image) }}" alt="Listing Image"
                                     class="w-96 aspect-square object-cover rounded-xl shadow-md border dark:border-gray-700 snap-center transition-transform aspect-w-16 aspect-h-9 relative">
                            @endif
                        @endforeach
                    </div>
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

            <!-- Add a Premium Banner -->
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
                    <p class="text-gray-600 dark:text-gray-300">
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
            <div class="text-sm text-gray-500 dark:text-gray-400 mt-6 flex justify-between p-2">
                <p class="text-gray-500 dark:text-gray-300">
                    👀 Viewed <strong>{{ $listing->views }}</strong> times
                </p>
                <p>📅 Created: {{ $listing->created_at->format('M d, Y') }}</p>
                <p>🕒 Updated: {{ $listing->updated_at->format('M d, Y') }}</p>
            </div>
        </div>
    </div>

    <!-- Mobile Action Buttons -->
    <div class="fixed bottom-0 z-10 w-full bg-gray-50 dark:bg-gray-900 border-t dark:border-gray-800 md:hidden p-4">
        @auth
            @if(auth()->user()->id === $listing->user_id)
                <a href="{{ route('listings.edit', $listing) }}" class="">
                    <x-button text="Edit Listing" additional-classes="w-full" />
                </a>
            @else
                <button onclick="openModal()"
                        class="block w-full text-center px-4 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700 transition duration-200">
                    Message Owner
                </button>
            @endif
        @else
            <a href="{{ route('login') }}"
               class="flex w-full justify-center items-center px-4 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition duration-200">
                <span>Login to Contact</span>
                <i class="fa fa-arrow-right ml-2"></i>
            </a>
        @endauth
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
            geocoder.geocode({ address: '{{ $listing->location }}' }, (results, status) => {
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
            modal.classList.remove('hidden');
            setTimeout(() => modal.querySelector('div').classList.remove('scale-95'), 10);
        }

        function closeModal() {
            const modal = document.getElementById('contactModal');
            modal.querySelector('div').classList.add('scale-95');
            setTimeout(() => modal.classList.add('hidden'), 200);
        }

        document.getElementById('contactModal')?.addEventListener('click', function(e) {
            if (e.target === this) closeModal();
        });
    </script>

</x-app-layout>

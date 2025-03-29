<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <!-- Premium Status Card -->
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <section>
                        <header>
                            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                                {{ __('Membership Status') }}
                            </h2>
                            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                                {{ __('View your current membership status and benefits.') }}
                            </p>
                        </header>

                        <div class="mt-6">
                            @if(auth()->user()->isPremium())
                                <div class="flex items-center bg-indigo-50 dark:bg-indigo-900/30 p-4 rounded-lg border border-indigo-200 dark:border-indigo-800">
                                    <div class="mr-4 flex-shrink-0">
                                        <svg class="h-8 w-8 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <h3 class="text-lg font-medium text-indigo-800 dark:text-indigo-300">Premium Member</h3>
                                        <p class="text-indigo-700 dark:text-indigo-400">
                                            Your premium membership is active
                                            @if(auth()->user()->premium_expires_at)
                                                until {{ auth()->user()->premium_expires_at->format('F j, Y') }}
                                            @endif
                                        </p>

                                        @if(auth()->user()->premium_expires_at && auth()->user()->isPremiumExpiringSoon())
                                            <p class="mt-2 text-amber-600 dark:text-amber-400">
                                                <svg class="inline-block h-5 w-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                                                </svg>
                                                Your premium membership will expire soon. Consider renewing.
                                            </p>
                                        @endif

                                        <div class="mt-3 flex space-x-3">
                                            <a href="#" class="text-sm text-indigo-600 hover:text-indigo-800 dark:text-indigo-400 dark:hover:text-indigo-300 font-medium">
                                                View Benefits
                                            </a>
                                            @if(auth()->user()->premium_expires_at)
                                                <form method="POST" action="{{ route('premium.cancel') }}" class="inline"
                                                      onsubmit="return confirm('Are you sure you want to cancel your premium subscription?');">
                                                    @csrf
                                                    <button type="submit" class="text-sm text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300 font-medium">
                                                        Cancel Subscription
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @else
                                <div class="flex items-center bg-gray-50 dark:bg-gray-700 p-4 rounded-lg border border-gray-200 dark:border-gray-600">
                                    <div class="mr-4 flex-shrink-0">
                                        <svg class="h-8 w-8 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <h3 class="text-lg font-medium text-gray-700 dark:text-gray-300">Standard Member</h3>
                                        <p class="text-gray-600 dark:text-gray-400">
                                            Upgrade to Premium to unlock advanced features
                                        </p>
                                        <div class="mt-3">
                                            <a href="{{ route('premium.upgrade') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-medium text-xs text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                                                Upgrade to Premium
                                            </a>
                                        </div>
                                    </div>
                                </div>

                                <div class="mt-4 bg-gradient-to-r from-indigo-500 to-purple-600 text-white p-4 rounded-lg">
                                    <h4 class="font-medium">Premium Benefits Include:</h4>
                                    <ul class="mt-2 space-y-1 list-disc list-inside text-sm">
                                        <li>View contact details for all listings</li>
                                        <li>Access to premium-only listings</li>
                                        <li>Advanced analytics and reports</li>
                                        <li>Priority customer support</li>
                                    </ul>
                                </div>
                            @endif
                        </div>
                    </section>
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
            Upgrade to Premium
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="text-center mb-8">
                        <h1 class="text-3xl font-bold">Unlock Premium Features</h1>
                        <p class="text-gray-600 dark:text-gray-400 mt-2">Get full access to contact details, advanced analytics, and more.</p>
                    </div>

                    <div class="grid md:grid-cols-2 gap-8 mt-10">
                        @foreach($plans as $planId => $plan)
                            <div class="border border-indigo-200 dark:border-indigo-800 rounded-lg overflow-hidden hover:shadow-lg transition-shadow">
                                <div class="bg-indigo-50 dark:bg-indigo-900/30 p-6">
                                    <h3 class="text-xl font-bold text-indigo-700 dark:text-indigo-300">{{ $plan['name'] }}</h3>
                                    <div class="mt-2">
                                        <span class="text-3xl font-bold">${{ $plan['price'] }}</span>
                                        @if($planId === 'monthly')
                                            <span class="text-gray-600 dark:text-gray-400">/month</span>
                                        @else
                                            <span class="text-gray-600 dark:text-gray-400">/year</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="p-6">
                                    <p class="text-gray-600 dark:text-gray-400">{{ $plan['description'] }}</p>
                                    <ul class="mt-4 space-y-3">
                                        <li class="flex items-start">
                                            <svg class="h-5 w-5 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                            </svg>
                                            <span>View contact details</span>
                                        </li>
                                        <li class="flex items-start">
                                            <svg class="h-5 w-5 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                            </svg>
                                            <span>Access premium listings</span>
                                        </li>
                                        <li class="flex items-start">
                                            <svg class="h-5 w-5 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                            </svg>
                                            <span>Advanced analytics</span>
                                        </li>
                                    </ul>
                                    <form method="POST" action="{{ route('premium.subscribe') }}" class="mt-6">
                                        @csrf
                                        <input type="hidden" name="plan" value="{{ $planId }}">
                                        <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-2 px-4 rounded-md transition-colors">
                                            Subscribe Now
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

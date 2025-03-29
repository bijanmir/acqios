<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PremiumController extends Controller
{
    public function showUpgradePage(): \Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
    {
        // You could get subscription plans from database or config
        $plans = [
            'monthly' => [
                'name' => 'Monthly Premium',
                'price' => 9.99,
                'duration' => 1,
                'description' => 'Full access to premium features',
            ],
            'yearly' => [
                'name' => 'Yearly Premium (Save 15%)',
                'price' => 99.99,
                'duration' => 12,
                'description' => 'Full access to premium features',
            ],
        ];

        return view('premium.upgrade', compact('plans'));
    }

    public function processSubscription(Request $request): \Illuminate\Http\RedirectResponse
    {
        $request->validate([
            'plan' => 'required|in:monthly,yearly',
            // Add other validation as needed
        ]);

        $plan = $request->plan;
        $user = Auth::user();

        // For testing purposes, we'll make the user premium right away
        // In production, you'd integrate with a payment gateway here
        $months = $plan === 'monthly' ? 1 : 12;
        $user->subscribeToPremium($months, 'demo_' . now()->timestamp);

        return redirect()->route('premium.success')
            ->with('success', 'You are now a premium member!');
    }

    public function showSuccess(): \Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
    {
        return view('premium.success');
    }

    public function cancelSubscription(Request $request): \Illuminate\Http\RedirectResponse
    {
        $user = Auth::user();
        $immediately = $request->has('immediately');

        $user->cancelPremium($immediately);

        return back()->with('success', 'Your premium subscription has been cancelled.');
    }
}

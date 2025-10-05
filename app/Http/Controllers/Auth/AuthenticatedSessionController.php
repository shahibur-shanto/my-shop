<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\Cart;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Inertia\Response;

class AuthenticatedSessionController extends Controller
{
    /**
     * Show the login page.
     */
    public function create(Request $request): Response
    {
        return Inertia::render('auth/Login', [
            'canResetPassword' => Route::has('password.request'),
            'status' => $request->session()->get('status'),
        ]);
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        return redirect()->intended(route('home', absolute: false));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }

//    protected function authenticated(Request $request, $user)
//    {
//        $sessionId = $request->session()->getId();
//
//        $sessionCart = Cart::where('session_id', $sessionId)->first();
//
//        if ($sessionCart) {
//            $userCart = Cart::firstOrCreate(['user_id' => $user->id]);
//
//            // Merge session items into user cart
//            foreach ($sessionCart->items as $item) {
//                $existingItem = $userCart->items()
//                    ->where('product_id', $item->product_id)
//                    ->where('variant_id', $item->variant_id)
//                    ->first();
//
//                if ($existingItem) {
//                    $existingItem->quantity += $item->quantity;
//                    $existingItem->save();
//                } else {
//                    $userCart->items()->create([
//                        'product_id' => $item->product_id,
//                        'variant_id' => $item->variant_id,
//                        'quantity' => $item->quantity,
//                    ]);
//                }
//            }
//
//            $sessionCart->delete();
//        }
//    }
}

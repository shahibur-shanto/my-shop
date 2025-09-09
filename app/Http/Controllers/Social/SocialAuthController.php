<?php

namespace App\Http\Controllers\Social;

use App\Http\Controllers\Controller;
use App\Models\SocialProvider;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class SocialAuthController extends Controller
{


    public function redirect(string $provider){

        return Socialite::driver( $provider)->redirect();
    }

    public function callback(string $provider){


        $providerUser = Socialite::driver( $provider)->user();

        $account = SocialProvider::query()
                                ->where('provider',$provider)
                                ->where('provider_id',$providerUser->getId())
                                ->first();
            if($account){
                $user = $account->user;
               Auth::login($user);
               return to_route('home');

            }
            else{
                $user = User::where('email', $providerUser->getEmail())->first();
                if (!$user) {
                    $user = User::create([
                        'name'  => $providerUser->getName(),
                        'email' => $providerUser->getEmail(),
                    ]);
                }

                SocialProvider::create([
                    'user_id'     =>$user->id,
                    'email'       => $providerUser->getEmail(),
                    'provider'    => $provider,
                    'provider_id' => $providerUser->getId(),
                    'avatar'      => $providerUser->getAvatar(),
                ]);
            }




//            $existingUser = User::query()
//                        ->where('provider_name', $provider)
//                        ->where('provider_id',$providerUser->getId())
//                        ->first();
//        if($existingUser){
//            Auth::login($existingUser);
//            return to_route('home');
//        }
//        $user = User::create([
//            'name'=> $providerUser->getName(),
//            'email'=> $providerUser->getEmail(),
//            'password'=>str('123456789'),
//            'provider_name'=> $provider,
//            'provider_id'=>$providerUser->getId(),
//        ]);
        Auth::login($user);
        return to_route('home');

    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
//        $user = Socialite::driver('github')->user();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}

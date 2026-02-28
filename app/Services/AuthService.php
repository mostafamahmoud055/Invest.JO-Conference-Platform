<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class AuthService
{
    public function register(array $data)
    {
        return DB::transaction(function () use ($data) {

            // 1️⃣ Create User
            $user = User::create([
                'email' => $data['email'],
                'password' => Hash::make('invest_jo_conference_platform'),
                'role' => 'visitor',
                'status' => 'active',
            ]);
            // 2️⃣ Create Profile
            $user->Profile()->create([
                'first_name' => $data['first_name'],
                'last_name' => $data['last_name'],
                'middle_name' => $data['middle_name'] ?? null,
                'family_name' => $data['family_name'] ?? null,
                'phone' => $data['phone'] ?? null,
                'job_title' => $data['job_title'],
                'website' => $data['website'] ?? null,
                'bio' => $data['bio'] ?? null,
                'linked_in_profile' => $data['linked_in_profile'] ?? null,
            ]);

            // 3️⃣ Travel Details (optional)
            if (!empty($data['nationality'])) {

                $passportPath = null;

                if (isset($data['passport_image'])) {
                    $passportPath = $data['passport_image']
                        ->store('passports', 'private');
                }

                $user->travelDetail()->create([
                    'nationality' => $data['nationality'],
                    'arrival_date' => $data['arrival_date'],
                    'arrival_time' => $data['arrival_time'],
                    'departure_date' => $data['departure_date'],
                    'departure_time' => $data['departure_time'],
                    'passport_image' => $passportPath,
                ]);
            }

            // Mail::raw('Welcome to Invest.JO!', function ($message) {
            //     $message->to('mostafamahmoud055@gmail.com') // ❌ Hardcoded email, replace with dynamic user email
            //         ->subject('Welcome');
            // });

            return  $user->load('Profile', 'travelDetail');
        });
    }

    // public function login(array $credentials): array
    // {
    //     if (!$token = Auth::attempt($credentials)) {
    //         return [
    //             'user'  => null,
    //             'token' => null,
    //         ];
    //     }

    //     return [
    //         'user'  => Auth::user(),
    //         'token' => $token,
    //     ];
    // }

    // public function logout(): void
    // {
    //     Auth::logout();
    // }

    public function me(): User
    {
        return Auth::user();
    }

    public function refresh(): array
    {
        $newToken = Auth::refresh();

        return [
            'user'  => Auth::user(),
            'token' => $newToken,
        ];
    }
}

<?php

namespace App\Services;

use App\Mail\UserLoggedInMail;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class AuthService
{
    public function register(array $data)
    {
        $user = DB::transaction(function () use ($data) {

            $user = User::create([
                'email' => $data['email'],
                'password' => Hash::make('invest_jo_conference_platform'),
                'role' => 'visitor',
                'status' => 'active',
            ]);

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

            if (!empty($data['nationality'])) {

                $passportPath = null;

                if (isset($data['passport_image'])) {
                    $passportPath = $data['passport_image']
                        ->store('passports', 'private');
                }

                $user->travelDetail()->create([
                    'nationality' => $data['nationality'],
                    'arrival_date' => $data['arrival_date'] ?? null,
                    'arrival_time' => $data['arrival_time'] ?? null,
                    'departure_date' => $data['departure_date'] ?? null,
                    'departure_time' => $data['departure_time'] ?? null,
                    'passport_image' => $passportPath,
                ]);
            }

            return $user;
        });

        Mail::to($user->email)->send(new UserLoggedInMail($user));

        $token = Auth::attempt([
            'email' => $data['email'],
            'password' => 'invest_jo_conference_platform',
        ]);

        return ['user' => $user->load('Profile', 'travelDetail'), 'token' => $token];
    }

     // إرسال OTP
    public function sendOtp(string $email): bool
    {
        $user = User::firstOrCreate(
            ['email' => $email],
            [
                'password' => Hash::make(Str::random(12)),
                'role' => 'visitor',
                'status' => 'active'
            ]
        );

        $otp = mt_rand(100000, 999999); // 6 أرقام
        $user->update([
            'otp_code' => $otp,
            'otp_expires_at' => Carbon::now()->addMinutes(5) // صلاحية 5 دقايق
        ]);

        // إرسال OTP عبر الإيميل
        Mail::to($user->email)->send(new UserLoggedInMail($user, $otp));

        return true;
    }

    // تحقق من OTP وعمل login
    public function verifyOtp(string $email, string $otp): ?string
    {
        $user = User::where('email', $email)
                    ->where('otp_code', $otp)
                    ->where('otp_expires_at', '>=', Carbon::now())
                    ->first();

        if (!$user) {
            return null; // OTP خطأ أو انتهت صلاحيته
        }

        // إعادة توليد token JWT
        $token = Auth::login($user);

        // مسح OTP بعد الاستخدام
        $user->update([
            'otp_code' => null,
            'otp_expires_at' => null
        ]);

        return $token;
    }


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
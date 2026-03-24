<?php

namespace App\Http\Controllers;

use App\Mail\InviteMail;
use App\Models\Invite;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class InviteController extends Controller
{
    public function create()
    {
        return view('invitation.invite');
    }

    public function send(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')],
        ]);

        $activeInvite = Invite::query()
            ->where('email', $request->email)
            ->whereNull('accepted_at')
            ->where(function ($query) {
                $query->whereNull('expires_at')->orWhere('expires_at', '>', Carbon::now());
            })
            ->latest('id')
            ->first();

        if ($activeInvite) {
            return back()
                ->withInput()
                ->withErrors(['email' => 'An active invite already exists for this email.']);
        }

        $invite = Invite::create([
            'email' => $request->email,
            'token' => $this->generateUniqueToken(),
            'expires_at' => Carbon::now()->addDays(7),
        ]);

        try {
            Mail::to($invite->email)->send(new InviteMail($invite));
        } catch (\Throwable $exception) {
            $invite->delete();
            report($exception);

            return back()
                ->withInput()
                ->withErrors(['email' => 'Invite email could not be sent. Please verify SMTP settings and try again.']);
        }

        return back()->with('success', 'Invitation sent successfully.');
    }

    public function showRegistrationForm(string $token)
    {
        $invite = Invite::where('token', $token)->first();

        if (! $invite || ! $invite->isValid()) {
            return redirect()->route('login')->with('error', 'Invalid or expired invite link.');
        }

        return view('auth.register-invite', compact('invite'));
    }

    public function register(Request $request, string $token)
    {
        $invite = Invite::where('token', $token)->first();

        if (! $invite || ! $invite->isValid()) {
            return redirect()->route('login')->with('error', 'Invalid or expired invite link.');
        }

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email'),
                function (string $attribute, mixed $value, \Closure $fail) use ($invite): void {
                    if (mb_strtolower((string) $value) !== mb_strtolower($invite->email)) {
                        $fail('This email does not match the invitation.');
                    }
                },
            ],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'image' => ['required', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
            'gender' => ['required', Rule::in(['male', 'female', 'other'])],
            'father_name' => ['required', 'string', 'max:255'],
            'mobile' => ['required', 'regex:/^[0-9]{10}$/'],
            'address' => ['required', 'string', 'max:1000'],
        ]);

        $imagePath = $request->hasFile('image')
            ? $request->file('image')->store('profile_images', 'public')
            : null;

        try {
            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'role' => 'Teacher',
                'gender' => $validated['gender'],
                'father_name' => $validated['father_name'],
                'mobile' => $validated['mobile'],
                'address' => $validated['address'],
                'image' => $imagePath,
            ]);

            $user->assignRole('Teacher');
            $invite->markAccepted();
        } catch (\Throwable $exception) {
            if ($imagePath !== null) {
                Storage::disk('public')->delete($imagePath);
            }

            throw $exception;
        }

        return redirect()->route('login')->with('success', 'Registration completed. You can now log in.');
    }

    private function generateUniqueToken(): string
    {
        do {
            $token = Str::random(64);
        } while (Invite::where('token', $token)->exists());

        return $token;
    }
}

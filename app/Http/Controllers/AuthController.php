<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Mail;
use App\Mail\WelcomeMail;
use App\Mail\PaymentMail;

class AuthController extends Controller
{

    public function sendEmail()
    {
        $email = new WelcomeMail();
        Mail::to('anggerrestu10@gmail.com')->send($email);

        return 'Email sent!';
    }

    public function login()
    {
        return view('Authorization/login');
    }

    public function register()
    {
        return view('Authorization/register');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('login');
    }

    public function registerProccess(Request $request)
    {
        // Validate request
        $validated = $request->validate([
            'email' => 'required|unique:users|max:255|email',
            'username' => 'required|max:255',
            'password' => 'required|max:255',
            'city' => 'required',
            'address' => 'required',
            'phone' => 'required',
            'shop_name' => 'required',
            'zip_code' => 'required',
        ]);

        // Save data into an array, hash the password
        $userData = [
            'email' => $request->email,
            'username' => $request->username,
            'password' => $request->password,  // Hash the password
            'city' => $request->city,
            'address' => $request->address,
            'phone' => $request->phone,
            'shop_name' => $request->shop_name,
            'zip_code' => $request->zip_code,
            'status' => 'inactive',  // Default status
        ];

        // Create a new user
        $user = User::create($userData);

        // Automatically log the user in
        Auth::login($user);

        // Send a welcome email
        $email = new WelcomeMail();  // Assumes WelcomeMail is set up to be a Mailable class
        Mail::to($user->email)->send($email);  // Send email to the registered email address

        Session::flash('status', 'success');
        Session::flash('message', 'Please select the duration for your active date.');

        // Redirect to active date selection page
        return redirect('select-active-date');
    }

    public function selectActiveDate()
    {
        return view('Authorization/select-active-date');
    }

    public function selectActiveDateNoTrial()
    {
        return view('Authorization/select-active-date-no-trial');
    }

    public function setActiveDate(Request $request)
    {
        $user = Auth::user();

        if ($request->has('duration')) {
            $duration = $request->input('duration');

            switch ($duration) {
                case '5_days':
                    $user->active_date = now()->addDays(5);
                    break;
                case '1_month':
                    $user->active_date = now()->addMonth();
                    break;
                case '1_year':
                    $user->active_date = now()->addYear();
                    break;
                default:
                    return redirect()->back()->withErrors(['Invalid duration selected']);
            }

            $user->status = 'active';  // Update status to active
            $user->save();

            // Send confirmation email
            $email = new PaymentMail($user); // Assuming WelcomeMail is the mailable class for confirmation emails
            Mail::to($user->email)->send($email); // Send email to the user's registered email address

            return redirect('/staff')->with('status', 'Your account is now active and a confirmation email has been sent.');
        }

        return redirect()->back()->withErrors(['Please select a duration']);
    }



    public function authenticating(Request $request)
    {
        // Mengambil username dan password dari permintaan
        $credentials = $request->only('username', 'password');

        // Mencari pengguna berdasarkan username
        $user = User::where('username', $credentials['username'])->first();

        // Jika pengguna ditemukan dan kata sandi cocok
        if ($user && $credentials['password'] == $user->password) {

            // Masukkan pengguna ke dalam sesi
            Auth::login($user);
            $request->session()->regenerate();

            // Cek status pengguna
            if ($user->status == 'active') {
                // Jika status pengguna aktif, redirect berdasarkan role
                if (Auth::user()->role == 'Admin') {
                    return redirect('/dashboard');
                } elseif (Auth::user()->role == 'User') {
                    return redirect('/staff');
                }
            } else {
                // Jika akun tidak aktif, redirect ke halaman pilih durasi active date
                return redirect()->route('selectActiveDateNoTrial')
                    ->with('status', 'inactive')
                    ->with('message', 'Your account is not active. Please select the duration for your active date.');
            }
        } else {
            // Jika autentikasi gagal
            Session::flash('status', 'failed');
            Session::flash('message', 'Invalid username or password');
        }

        // Redirect ke halaman login
        return redirect('login');
    }


    public function redirectBasedOnRole()
    {
        if (Auth::check()) {

            $role = Auth::user()->role;

            if ($role == 'Admin') {
                return redirect('/dashboard');
            } elseif ($role == 'User') {
                return redirect('/staff');
            }
        }

        return redirect('login');
    }

}

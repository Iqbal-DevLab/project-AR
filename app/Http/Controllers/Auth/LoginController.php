<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Auth\Authenticatable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    use Authenticatable;

    public function index()
    {
        return view('auth.login', [
            'title' => 'Login',
        ]);
    }

    // login function
    public function authlogin(Request $request)
    {
        $credentials = $request->validate([
            'nik_karyawan' => 'required',
            'password' => 'required',
        ]);

        $user = User::where('nik_karyawan', 'like', '%' . $request->nik_karyawan . '%')->first();

        // check if user not exist
        if (!$user) {
            return back()->with('error', 'Username atau Password salah!');
        }

        // check if user not active
        // if ($user->status_user != 1) {
        //     return back()->with('error', 'Akun anda tidak aktif!');
        // }

        // login if user role finance
        if ($user->role_id == 1) {
            if (Auth::attempt($credentials)) {
                $request->session()->regenerate();
                // update last login
                $user->last_login = Carbon::now();
                $user->save();
                return redirect()->intended('/dashboard');
            }
            return back()->with('error', 'Username atau Password salah!');
        }

        // login if user role sales
        if ($user->role_id == 2) {
            if (Auth::attempt($credentials)) {
                $request->session()->regenerate();
                // update last login
                $user->last_login = date('Y-m-d H:i:s');
                $user->save();
                return redirect()->intended('/sales');
            }
            return back()->with('error', 'Username atau Password salah!');
        }

        // login if user role logistik
        if ($user->role_id == 3) {
            if (Auth::attempt($credentials)) {
                $request->session()->regenerate();
                // update last login
                $user->last_login = date('Y-m-d H:i:s');
                $user->save();
                return redirect()->intended('/logistik');
            }
            return back()->with('error', 'Username atau Password salah!');
        }

        // login if user role produksi
        if ($user->role_id == 4) {
            if (Auth::attempt($credentials)) {
                $request->session()->regenerate();
                $user->last_login = date('Y-m-d H:i:s');
                $user->save();
                return redirect()->intended('/produksi');
            }
            return back()->with('error', 'Username atau Password salah!');
        }
    }

    // logout function
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}

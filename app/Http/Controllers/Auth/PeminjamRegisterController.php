<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class PeminjamRegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.register_peminjam');
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required','string','max:255'],
            'email' => ['required','string','email','max:255','unique:users,email'],
            'password' => ['required','string','min:8','max:20','confirmed'],
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $user = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
        ]);

        // attach or create role peminjam
        $role = Role::firstOrCreate(['name' => 'peminjam'], ['label' => 'Peminjam']);
        $user->roles()->attach($role->id);

        // auto login user after registration
        Auth::login($user);

        return redirect()->route('dashboard');
    }
}

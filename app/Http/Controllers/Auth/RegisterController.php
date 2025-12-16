<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    protected $creator;

    public function __construct(CreatesNewUsers $creator)
    {
        $this->creator = $creator;
    }
    public function show()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $user = $this->creator->create($request->all());

        event(new Registered($user));
        Auth::logout();

        return redirect()
            ->route('login')
            ->with('success', 'Akun berhasil dibuat. Silakan login.');
    }
}

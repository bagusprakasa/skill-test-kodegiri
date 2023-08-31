<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Mail\SendMail;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Carbon\Carbon;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(RegisterRequest $request)
    {
        DB::beginTransaction();
        try {
            $user = $request->all();
            $model = User::create($user);
            DB::commit();
            Mail::to($model->email)->send(new SendMail($model));
            return redirect()->route('register')->with('success', 'Successfully registered please check your email for activation account');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Something wrong. : ' . $e->getMessage());
        } catch (\Illuminate\Database\QueryException $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Something wrong on database : ' . $e->getMessage());
        }
    }
    public function verification($id, Request $request)
    {
        try {
            $checkId = Hash::check($id, $request->key);
            if ($checkId == true) {
                User::findOrFail($id)->update([
                    'email_verified_at' => Carbon::now(),
                ]);
                return redirect()->route('login')->with('success', 'Your account successfully activated');
            }
        } catch (\Exception $e) {
            return redirect()->route('login')->with('error', 'Something wrong. : ' . $e->getMessage());
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()->route('login')->with('error', 'Something wrong on database : ' . $e->getMessage());
        }
    }
    public function resend($id, Request $request)
    {
        try {
            $checkId = Hash::check($id, $request->key);
            if ($checkId == true) {
                Auth::guard('web')->logout();

                $request->session()->invalidate();

                $request->session()->regenerateToken();
                $model = User::findOrFail($id);
                Mail::to($model->email)->send(new SendMail($model));
                return redirect()->route('login')->with('success', 'Your activation was successfully resend, check your email');
            }
        } catch (\Exception $e) {
            return redirect()->route('login')->with('error', 'Something wrong. : ' . $e->getMessage());
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()->route('login')->with('error', 'Something wrong on database : ' . $e->getMessage());
        }
    }
}

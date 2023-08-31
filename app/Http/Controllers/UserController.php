<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class UserController extends Controller
{
    public function index()
    {
        $title = 'Profile';
        $model = User::with('profile')->findOrFail(Auth::user()->id);
        $profile = Profile::where('user_id', $model->id)->first();
        $data = array(
            'list' => 'Profile',
            'menu' => 'Profile',
            'data' => $model,
        );
        return view('pages.profile.index', compact('title', 'data'));
    }

    public function edit()
    {
        $title = 'Profile';
        $model = Auth::user();
        $profile = Profile::where('user_id', $model->id)->first();
        $data = array(
            'list' => 'Edit Profile',
            'menu' => 'Profile',
            'type' => 'edit',
            'data' => (object)array(
                'name' => $model->name,
                'email' => $model->email,
                'phone' => $model->phone,
                'company' => $profile != null ? $profile->company : '',
                'division' => $profile != null ? $profile->division : '',
                'profile_image' => $profile != null ? $profile->profile_image : '',
            ),
        );
        return view('pages.profile.form', compact('title', 'data'));
    }

    public function update(UserRequest $request)
    {
        DB::beginTransaction();
        try {
            $user = User::findOrFail(Auth::user()->id);
            $user->name = $request->name;
            $user->email = $request->email;
            $user->phone = $request->phone;
            $user->save();

            $checkProfile = Profile::where('user_id', $user->id)->first();
            if (!$checkProfile) {
                $profile = new Profile();
            } else {
                $profile = Profile::where('user_id', $user->id)->first();
                if ($request->profile_image) {
                    File::delete($profile->signing);
                }
            }
            $profile->division = $request->division;
            $profile->company = $request->company;
            $profile->user_id = $user->id;
            if ($request->profile_image) {
                $document = $request->profile_image;
                $document->storeAs('public/profile', $document->hashName());
                $profile->photo_profile = 'storage/profile/' . $document->hashName();
            }
            $profile->save();

            DB::commit();
            // return redirect()->route('register')->with('success', 'Successfully registered please check your email for activation account');
            return redirect()->back()->with('success', 'Successfully updated your account');
        } catch (\Exception $e) {
            DB::rollback();
            return $e->getMessage();
            return redirect()->back()->with('error', 'Something wrong. : ' . $e->getMessage());
        } catch (\Illuminate\Database\QueryException $e) {
            DB::rollback();
            return $e->getMessage();
            return redirect()->back()->with('error', 'Something wrong on database : ' . $e->getMessage());
        }
    }
}

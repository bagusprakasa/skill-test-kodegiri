<?php

namespace App\Http\Controllers\API\v1;

use App\Helpers\Helpers;
use App\Http\Controllers\Controller;
use App\Mail\SendMail;
use App\Models\Profile;
use App\Models\User;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    public function register(Request $request)
    {
        DB::beginTransaction();

        try {
            $req = $request->all();
            $arrValidate = [
                'name' => 'required',
                'email' => 'required|email:rfc,dns|unique:users,email',
                'phone' => 'required',
                'password' => 'required',
                'confirmation' => 'required|same:password',
            ];
            $fields = Validator::make(
                $req,
                $arrValidate
            );
            if ($fields->fails()) {
                return Helpers::errorResponse(null, $fields->errors(), Response::HTTP_UNPROCESSABLE_ENTITY);
            } else {
                $model = new User();
                $model->name = $request->name;
                $model->email = $request->email;
                $model->phone = $request->phone;
                $model->password = Hash::make($request->password);
                $model->save();
                DB::commit();
                Mail::to($model->email)->send(new SendMail($model));
                return Helpers::succesResponse($model, 'Register successfully.');
            }
        } catch (\Exception $e) {
            DB::rollback();
            return Helpers::errorResponse(null, 'Something wrong. : ' . $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        } catch (\Illuminate\Database\QueryException $e) {
            DB::rollback();
            return Helpers::errorResponse(null, 'Something wrong on database. : ' . $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function login(Request $request)
    {
        DB::beginTransaction();

        try {
            $data = User::where('email', $request->email)->first();
            if ($data) {
                if ($data->email_verified_at != null) {
                    if (Hash::check($request->password, $data->password)) {
                        $token = $data->createToken('auth_token')->plainTextToken;
                        $dataJson = [
                            'data' => $data,
                            'access_token' => $token,
                            'token_type' => 'Bearer'
                        ];
                        return Helpers::succesResponse($dataJson, 'Login sukses', Response::HTTP_OK);
                    } else {
                        return Helpers::errorResponse(null, 'Password salah', Response::HTTP_INTERNAL_SERVER_ERROR);
                    }
                } else {
                    return Helpers::errorResponse(null, 'Akun anda belum aktif', Response::HTTP_UNAUTHORIZED);
                }
            } else {
                return Helpers::errorResponse(null, 'Akun tidak ditemukan', Response::HTTP_INTERNAL_SERVER_ERROR);
            }
        } catch (\Exception $e) {
            return Helpers::errorResponse(null, 'Something wrong. : ' . $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        } catch (\Illuminate\Database\QueryException $e) {
            return Helpers::errorResponse(null, 'Something wrong on database. : ' . $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function update($id, Request $request)
    {
        DB::beginTransaction();

        try {
            $req = $request->all();
            $arrValidate = [
                'name' => 'required',
                'email' => 'required|email:rfc,dns|unique:users,email,' . $id,
                'phone' => 'required',
                'company' => 'required',
                'division' => 'required',
            ];
            $fields = Validator::make(
                $req,
                $arrValidate
            );
            if ($fields->fails()) {
                return Helpers::errorResponse(null, $fields->errors(), Response::HTTP_UNPROCESSABLE_ENTITY);
            } else {

                $user = User::findOrFail($id);
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
                        File::delete($profile->profile_image);
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
                $data = array(
                    'user' => $user,
                    'profile' => $profile,
                );

                DB::commit();
                return Helpers::succesResponse($data, 'Update Profile successfully.');
            }
        } catch (\Exception $e) {
            return Helpers::errorResponse(null, 'Something wrong. : ' . $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        } catch (\Illuminate\Database\QueryException $e) {
            return Helpers::errorResponse(null, 'Something wrong on database. : ' . $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}

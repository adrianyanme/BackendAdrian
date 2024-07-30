<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Profile;
use App\Mail\VerifyEmail;
use Illuminate\Http\Request;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Http\Resources\UserResourceAll;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Storage;

class AuthenticationController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'login' => 'required',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->login)
            ->orWhere('username', $request->login)
            ->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'login' => ['The provided credentials are incorrect.'],
            ]);
        }

        $token = $user->createToken('user login')->plainTextToken;

        return response()->json([
            'token' => $token,
            'role' => $user->role,
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
    }

    public function me(Request $request)
    {
        return response()->json(Auth::user());
    }
    // public function updateProfile(Request $request)
    // {
    //     $user = Auth::user();

    //     $validator = Validator::make($request->all(), [
    //         'email' => 'sometimes|required|email|unique:users,email,' . $user->id,
    //         'firstname' => 'sometimes|required',
    //         'lastname' => 'sometimes|required',
    //         'ktp_image' => 'sometimes|required|image|mimes:jpeg,png,jpg|max:2048',
    //         'profileimg' => 'sometimes|required|image|mimes:jpeg,png,jpg|max:2048',
    //     ]);

    //     if ($validator->fails()) {
    //         return response()->json(['errors' => $validator->errors()], 422);
    //     }

    //     if ($request->hasFile('ktp_image')) {
    //         $file = $request->file('ktp_image');
    //         if ($file->isValid()) {
    //             $ktpimage = $file->getClientOriginalName();
    //             Storage::putFileAs('public/ktpimage', $file, $ktpimage);
    //             $user->ktp_image = $ktpimage;
    //         } else {
    //             throw new \Exception('Invalid file ktp image.');
    //         }
    //     }

    //     if ($request->hasFile('profileimg')) {
    //         $file = $request->file('profileimg');
    //         if ($file->isValid()) {
    //             $profileimage = $file->getClientOriginalName();
    //             Storage::putFileAs('public/profileimg', $file, $profileimage);
    //             $user->profileimg = $profileimage;
    //         } else {
    //             throw new \Exception('Invalid file uploaded profileimg.');
    //         }
    //     }

    //     // Update attributes manually
    //     if ($request->has('email')) {
    //         $user->email = $request->email;
    //     }
    //     if ($request->has('firstname')) {
    //         $user->firstname = $request->firstname;
    //     }
    //     if ($request->has('lastname')) {
    //         $user->lastname = $request->lastname;
    //     }

    //     $user->save(); 

    //     return new UserResource($user);
    // End of Selection
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:users',
            'username' => 'required|unique:users',
            'firstname' => 'required',
            'lastname' => 'required',
            'password' => 'required|min:6',
            'nik' => 'required|unique:users',
            'ktp_image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'profileimg' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $ktpimage = null;
        if ($request->hasFile('ktp_image')) {
            $file = $request->file('ktp_image');
            if ($file->isValid()) {
                $ktpimage = $file->getClientOriginalName(); // Perbaikan di sini
                Storage::putFileAs('public/ktpimage', $file, $ktpimage);
            } else {
                throw new \Exception('Invalid file ktp image.');
            }
        }

        $profileimage = null;
        if ($request->hasFile('profileimg')) {
            $file = $request->file('profileimg');
            if ($file->isValid()) {
                $profileimage = $file->getClientOriginalName(); // Perbaikan di sini
                Storage::putFileAs('public/profileimg', $file, $profileimage);
            } else {
                throw new \Exception('Invalid file uploaded profileimg.');
            }
        }

        $user = User::create([
            'email' => $request->email,
            'username' => $request->username,
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'password' => Hash::make($request->password),
            'nik' => $request->nik,
            'role' => 'user',
            'ktp_image' => $ktpimage, // Pastikan variabel ini diisi
            'profileimg' => $profileimage, // Pastikan variabel ini diisi
            'verified' => 'No', // Default status verifikasi
        ]);

        return new UserResource($user);
    }


    public function verifyEmail($id)
    {
        $user = User::find($id);

        if ($user) {
            $user->email_verified_at = now();
            $user->verified = 'Yes';
            $user->save();

            return view('verify_success');
        }

        return response()->json(['message' => 'User not found.'], 404);
    }

    public function index()
    {
        $data = User::all();
        return UserResourceAll::collection($data);
    }
    public function updateVerificationStatus(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'verified' => 'required|in:Yes,No',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $user = User::find($id);

        if (!$user) {
            return response()->json(['message' => 'User not found.'], 404);
        }

        $user->verified = $request->verified;
        $user->save();

        return response()->json(['message' => 'Verification status updated successfully.']);
    }
}

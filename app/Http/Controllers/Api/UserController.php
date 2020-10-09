<?php

namespace App\Http\Controllers\Api;

use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Http\Resources\SingleArt;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'device_name' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            // throw ValidationException::withMessages([
            //     'email' => ['The provided credentials are incorrect.'],
            // ]);
            //if authentication is unsuccessfull, notice how I return json parameters
            return response()->json([
                'success' => false,
                'message' => 'Invalid Email or Password',
            ], 401);
        }

        return response()->json([
            'success' => true,
            'token' => $user->createToken($request->device_name)->plainTextToken,
            'user' => $user
        ]);
    }
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            // 'phone' => 'required|unique:users|regex:/(0)[0-9]{10}/',
            'email' => 'required|email|unique:users',
            'password' => 'required',
            'device_name' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors(),
            ], 401);
        }
        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);
        $success['token'] = $user->createToken($request->device_name)->plainTextToken;
        return response()->json([
            'success' => true,
            'token' => $success,
            'user' => $user
        ]);
    }

    public function art()
    {
        $user = Auth::user();

        $art = $user->art;
        return response()->json(["message" => "Art Retrieved Successfully", 'success' => true, "data" =>  SingleArt::collection($art)]);
    }

    public function logout(Request $request)
    {
        if (Auth::user()) {

            $request->user()->currentAccessToken()->delete();

            return response()->json([
                'success' => true,
                'message' => 'Logout successfully'
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Unable to Logout'
            ]);
        }
    }

    public function follow(Request $request)
    {

        $user1 = $request->user();

        $user2 = User::find($request->user2);

        if ($user1->follow($user2)) {
            return response()->json(["message" => "Successfully Followed " . $user2->name, 'success' => true]);
        } else {
            return response()->json(["message" => "An error occured while trying to follow " . $user2->name, 'success' => true]);
        }
    }

    public function unfollow(Request $request)
    {
        $user1 = $request->user();

        $user2 = User::find($request->user2);

        if ($user1->unfollow($user2)) {
            return response()->json(["message" => "Successfully Followed " . $user2->name, 'success' => true]);
        } else {
            return response()->json(["message" => "An error occured while trying to follow " . $user2->name, 'success' => true]);
        }
    }

    public function getFollowers(User $user)
    {
        // $user = $request->user();

        $followers = $user->followers;

        return response()->json(["message" => "Followers Retrieved Successfully", 'success' => true, "data" =>  UserResource::collection($followers)]);
    }

    public function getFollowings($user)
    {
        $user = User::find($user);
        // dd($user);

        $followings = $user->followings;

        return response()->json(["message" => "Followings Retrieved Successfully", 'success' => true, "data" =>  UserResource::collection($followings)]);
    }
}

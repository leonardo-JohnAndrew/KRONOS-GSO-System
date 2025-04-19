<?php

namespace App\Http\Controllers;

use App\Models\department;
use App\Models\organization;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpKernel\Event\ResponseEvent;

class AuthController extends Controller
{
    //show all 
    public function showall() {}
    //show department 
    public function department()
    {
        $departments = department::with(['organizations.positions'])->get();
        return $departments;
    }
    public function register(Request $request)
    {
        $data =  $request->validate([
            // 'userid'=>'required|max:100',
            'firstname' => 'required|max:255',
            'middlename' => 'required|max:255',
            'lastname' => 'required|max:255',
            'userRole' => 'required|max:255',
            'dprmtName' => 'required|max:255',
            'organization' => 'required|max:255',
            'officerPosition' => 'required|max:255',
            'organization' => 'required|max:255',
            'archive' => 'in:Yes,No',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed',
        ]);
        $user =  User::create($data);

        $token = $user->createToken($request->lastname);
        return [
            'userid' => $user->userid,
            'user' => $user,
            'access_token' => $token->plainTextToken
        ];
    }
    public function login(Request $request)
    {
        $request->validate([

            // 'firstname' =>'required|max:255',
            // 'middlename' =>'required|max:255',
            // 'lastname' =>'required|max:255',
            // 'userRole' =>'required|max:255',
            // 'dprmtName' =>'required|max:255',
            // 'organization' =>'required|max:255',
            // 'officerPosition' =>'required|max:255',
            // 'organization' =>'required|max:255',
            // 'archive' =>'in:Yes,No',
            'userid' => "max:255",
            'email' => 'email',
            'password' => 'required',

        ]);
        $user = User::where('userid', $request->userid)
            ->orWhere('email', $request->email)
            ->first();
        if (!$user || !Hash::check($request->password, $user->password)) {
            return [
                'message' => 'The provided credentials is incorrect'
            ];
        }


        $token = $user->createToken($user->lastname);
        return response()->json([
            "user" => $user,
            "access_token" => $token->plainTextToken
        ], 200);
    }
    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();
        return [
            'message' => 'The user is logout'
        ];
    }
}

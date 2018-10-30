<?php
namespace App\Http\Controllers\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Illuminate\Support\Facades\Auth;
use JWTAuth;
use Validator;
class AuthController extends Controller
{
    /**
     * API Login, on success return JWT Auth token
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request)
    {
        return view('index');
    }
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        $rules = [
            'email' => 'required|email',
            'password' => 'required',
        ];
        $validator = Validator::make($credentials, $rules);
        if($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->messages()
            ]);
        }
        try {
            // Attempt to verify the credentials and create a token for the user
            if (! $token = JWTAuth::attempt($credentials)) {
                return redirect()->back();
            }
        } catch (JWTException $e) {
            // Something went wrong with JWT Auth.
            return abort(500);
        }
        // All good so return the token
        return redirect('/index?token='.$token);
    }
    /**
     * Logout
     * Invalidate the token. User have to relogin to get a new token.
     * @param Request $request 'header'
     */
    public function logout(Request $request)
    {
        // Get JWT Token from the request header key "Authorization"
        $token = $request->header('Authorization');
        // Invalidate the token
        try {
            JWTAuth::invalidate($token);
            return response()->json([
                'status' => 'success',
                'message'=> "User successfully logged out."
            ]);
        } catch (JWTException $e) {
            // something went wrong whilst attempting to encode the token
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to logout, please try again.'
            ], 500);
        }
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

use Illuminate\Support\Facades\Cookie;
class LoginController extends Controller
{   
    public $API_REST; 
    public $USER_ID;
    public $USER_TOKEN;

    function __construct() {
        $this->API_REST = env('API_REST',null);
        $this->USER_ID = get_cookie('USER-ID');
        $this->USER_TOKEN =get_cookie('USER-TOKEN');
    }
    public function index(Request $request)
    {
       return  view('login.index');
    }
   
    public function authenticated(Request $request)
    {
        
      
        $body = [
            'email' => $request->email,
            'password' => $request->password,
        ];
        $response = Http::post("$this->API_REST/login", $body);
        return response()->json([
            'message' =>$response
        ], 201);
    
    }
    public function logout(Request $request)
    {
        $response = Http::withToken($this->USER_TOKEN)
         ->accept('application/json')
         ->post("$this->API_REST/logout");
        return response()->json($response->json());
    
    }
}

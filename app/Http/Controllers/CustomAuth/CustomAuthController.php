<?php
namespace App\Http\Controllers\CustomAuth;

use App\Helpers\HttpHelper;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Exception;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;

class CustomAuthController extends Controller {
    private $httpHelper;
    /**
     * CustomAuthController constructor.
     */
    public function __construct() {
        //initialize HttpHelper
        $this->httpHelper = new HttpHelper();
    }
    /**
     * Show the main login page
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showLoginForm(Request $request) {
        return view('auth.login');
    }
    /**
     * Authenticate against the  API
     * @param AuthenticationRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
     public function login(Request $request) {
        //attempt API authentication
        try {
            $result = $this->httpHelper->post("users/login", [
                'email' => $request->email,
                'password' => $request->password
            ]);
            $authHeader = $result->getHeader('Authorization');
            $body = $result->json();

            //create user to store in session
            $user = new User();
            /* Set any  user specific fields returned by the api request*/
            $user->email = $body['email'];
            $user->nombre = $body['nombre'];
            $user->apellidos = $body['apellidos'];
            $user->urlFoto = $body['url_foto'];
            $user->nombre = $body['nombre'];
            $user->telefono = $body['telefono'];
            $user->token = $authHeader;

            $request->session()->put('auth_token', $authHeader);
            $request->session()->put('user', $user);
        } catch(\GuzzleHttp\Exception\ClientException $e) {
            \Log::error('Login request error: '.$e);
            //track login attempt
            //$this->incrementThrottleValue("login", $this->generateLoginThrottleHash($request));
            //remove user and authenticated from session
            $request->session()->forget('auth_token');
            $request->session()->forget('user');
            //redirect back with error
            return redirect()->back()->withErrors('The credentials do not match our records');
        }
        //login success - redirect to home page
        //$this->resetThrottleValue("login", $this->generateLoginThrottleHash($request));
        return redirect()->action("HomeController@index");
    }

    /**
     * Log user out
     * @param Request $request
     * @return type
     */
    public function logout(Request $request) {
        //remove authenticated from session and redirect to login
        $request->session()->forget('auth_token');
        $request->session()->forget('user');
        return redirect()->route('login');
    }

    // Login throttling functions

    /**
     * @param Request $request
     * @return string
     */
    private function generateLoginThrottleHash(Request $request) {
        return md5($request->email . "_" . $request->getClientIp());
    }
}

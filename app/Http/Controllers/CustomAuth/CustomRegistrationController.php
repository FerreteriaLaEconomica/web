<?php
namespace App\Http\Controllers\CustomAuth;

use App\Helpers\HttpHelper;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use Laravolt\Avatar\Facade as Avatar;

class CustomRegistrationController extends Controller {
    private $httpHelper;

    /**
     * CustomRegistrationController constructor.
     */
    public function __construct() {
        //initialize HttpHelper
        $this->httpHelper = new HttpHelper();
    }

    /**
     * Show registration form
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showRegistrationForm(Request $request) {
        if ($request->session()->get('auth_token') !== null) {
            $user = $request->session()->get('user');
            Auth::login($user);
        }
        return view("auth.register");
    }

    //
    public function register(Request $request) {
        $validatedData = $request->validate([
            'nombre' => 'required|max:255',
            'apellidos' => 'required|max:255',
            'telefono' => 'required|size:10',
            'email' => 'required',
            'password' => 'confirmed|min:5',
        ]);

        $destinationPath = '/storage/avatars/'.time().'.png';
        $completePath = public_path().$destinationPath;
        $urlFoto = url($destinationPath);
        \Log::info($urlFoto);
        Avatar::create($request->nombre.' '.$request->apellidos)->save($completePath);

        try {
            $result = $this->httpHelper->post("users", [
                'nombre' => $request->nombre,
                'apellidos' => $request->apellidos,
                'telefono' => $request->telefono,
                'email' => $request->email,
                'password' => $request->password,
                'url_foto' => $urlFoto,
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
            \Log::error('Register request error: '.$e);

            $request->session()->forget('auth_token');
            $request->session()->forget('user');
            //return back with errors
            return redirect()->back()->withErrors('Ya existe un usuario con el mismo correo');
        }
        //return to login page after registration
        return redirect('/home');
        //return redirect()->back();
    }
}

<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use App\Helpers\HttpHelper;

class CategoriasController extends Controller
{
    private $httpHelper;
    private $token;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->httpHelper = new HttpHelper();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $categoriasResponse = $this->httpHelper->get('categorias/');
        $categorias = $categoriasResponse->json();
        return view('admin.categorias.index', compact('categorias'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        return view('admin.categorias.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $this->token = $request->session()->get('auth_token');
        $this->validate($request, [
            'nombre' => 'required|max:255'
        ]);
        $req = array();
        $req['nombre'] = $request->get('nombre');
        $response = $this->httpHelper->postAuth('categorias/', $req, $this->token)->json();

        Session::flash('message', 'Categoría creada con éxito!');
        return redirect()->route('categorias.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $categoriasResponse = $this->httpHelper->get('categorias/'.$id);
        $categoria = $categoriasResponse->json();

        return view('admin.categorias.edit')
            ->with('categoria', $categoria);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->token = $request->session()->get('auth_token');
        $this->validate($request, [
            'nombre' => 'required|max:255'
        ]);
        $req = array();
        $req['nombre'] = $request->get('nombre');
        $response = $this->httpHelper->putAuth('categorias/'.$id, $req, $this->token)->json();
        Session::flash('message', 'Categoría actualizada con éxito!');
        return redirect()->route('categorias.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id) {
        $this->token = $request->session()->get('auth_token');

        $categoriasResponse = $this->httpHelper->deleteAuth('categorias/'.$id, $this->token);
        $categorias = $categoriasResponse->json();
        Session::flash('message', 'Categoría borrada con éxito!');
        return redirect()->route('categorias.index');
    }
}

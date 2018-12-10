<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use App\Helpers\HttpHelper;

class ProductosController extends Controller
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
        $productosResponse = $this->httpHelper->get('productos/');
        $productos = $productosResponse->json();
        return view('admin.productos.index', compact('productos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $cats = $this->httpHelper->get('categorias')->json();
        $categorias = array();
        foreach($cats as $c) {
            $categorias[$c['nombre']] = $c['nombre'];
        }
        return view('admin.productos.create', compact('categorias'));
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
            'nombre' => 'required|max:255',
            'descripcion' => 'required|max:255',
            'precio' => 'required',
            'codigo_barras' => 'required|max:255',
            'url_foto' => 'required',
            'categoria' => 'required'
        ]);
        $imageName = time().'.'.$request->file('url_foto')->getClientOriginalExtension();
        $request->file('url_foto')->move(
            base_path() . '/public/images/', $imageName
        );

        $req = array();
        $req['nombre'] = $request->get('nombre');
        $req['descripcion'] = $request->get('descripcion');
        $req['precio_venta'] = (double) $request->get('precio');
        $req['categoria'] = $request->get('categoria');
        $req['precio_compra'] = 0.0;
        $req['porcentaje_descuento'] = 0;
        $req['codigo_barras'] = $request->get('codigo_barras');
        $req['formato'] = 'PIEZA';
        $req['url_foto'] = $imageName;
        $response = $this->httpHelper->postAuth('productos/', $req, $this->token)->json();

        Session::flash('message', 'Producto creado con éxito!');
        return redirect()->route('productos.index');
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
    public function edit($id) {
        $productosResponse = $this->httpHelper->get('productos/'.$id);
        $producto = $productosResponse->json();
        $cats = $this->httpHelper->get('categorias')->json();
        $categorias = array();
        foreach($cats as $c) {
            $categorias[$c['nombre']] = $c['nombre'];
        }
        return view('admin.productos.edit')
            ->with('producto', $producto)
            ->with('categorias', $categorias);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        $this->token = $request->session()->get('auth_token');
        $this->validate($request, [
            'nombre' => 'required|max:255',
            'descripcion' => 'required|max:255',
            'precio' => 'required',
            'categoria' => 'required'
        ]);
        $productosResponse = $this->httpHelper->get('productos/'.$id)->json();
        $cateResponse = $this->httpHelper->get('categorias/'.$request->get('categoria'))->json();
        if ($request->file('url_foto') === null) {
            $req = array();
            $req['nombre'] = $request->get('nombre');
            $req['descripcion'] = $request->get('descripcion');
            $req['precio_venta'] = (double) $request->get('precio');
            $req['categoria'] = $cateResponse['nombre'];
            $req['precio_compra'] = 0.0;
            $req['porcentaje_descuento'] = $productosResponse['porcentaje_descuento'];
            $req['codigo_barras'] = $productosResponse['codigo_barras'];
            $req['formato'] = $productosResponse['formato'];
            $req['url_foto'] = $productosResponse['url_foto'];

            Log::info($req);
            $response = $this->httpHelper->putAuth('productos/'.$id, $req, $this->token)->json();
        } else {
            $imageName = time().'.'.$request->file('url_foto')->getClientOriginalExtension();
            $request->file('url_foto')->move(
                base_path() . '/public/images/', $imageName
            );
            $req = array();
            $req['nombre'] = $request->get('nombre');
            $req['descripcion'] = $request->get('descripcion');
            $req['precio_venta'] = $request->get('precio');
            $req['categoria'] = $request->get('categoria');
            $req['precio_compra'] = 0.0;
            $req['porcentaje_descuento'] = $productosResponse['porcentaje_descuento'];
            $req['codigo_barras'] = $productosResponse['codigo_barras'];
            $req['formato'] = $productosResponse['formato'];
            $req['url_foto'] = $imageName;
            $response = $this->httpHelper->putAuth('productos/'.$id, $req, $this->token)->json();
        }
        Session::flash('message', 'Producto actualizado con éxito!');
        return redirect()->route('productos.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id) {
        $this->token = $request->session()->get('auth_token');
        Log::info($this->token);
        $productosResponse = $this->httpHelper->deleteAuth('productos/'.$id, $this->token);
        $productos = $productosResponse->json();
        Session::flash('message', 'Producto borrado con éxito!');
        return redirect()->route('productos.index');
    }
}

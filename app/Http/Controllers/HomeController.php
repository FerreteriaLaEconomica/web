<?php

namespace App\Http\Controllers;

use App\Helpers\HttpHelper;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller {
    private $httpHelper;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->httpHelper = new HttpHelper();
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {
        return redirect()->route('home', ['idSucursal' => 1]);
    }

    public function showProduct(Request $request, $idSucursal, $idProducto) {
        if ($request->session()->get('auth_token') !== null) {
            $user = $request->session()->get('user');
            Auth::login($user);
        }
        $productosResponse = $this->httpHelper->get("sucursales/".$idSucursal.'/productos/'.$idProducto);
        $producto = $productosResponse->json();
        //return redirect()->route('home', ['idSucursal' => 1]);
        return view('producto-detalles', compact('producto'));
    }

    public function showById(Request $request, $idSucursal) {
        if ($request->session()->get('auth_token') !== null) {
            $user = $request->session()->get('user');
            Auth::login($user);
        }
        $result = $this->httpHelper->get("sucursales");
        $sucursales = $result->json();
        $productosResponse = $this->httpHelper->get("sucursales/".$idSucursal.'/productos');
        $productos = $productosResponse->json();

        $categoriasResponse = $this->httpHelper->get("categorias");
        $categorias = $categoriasResponse->json();

        $data = array();
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $collection = new Collection($productos);
        $perPage = 15;
        $currentPageResults = $collection->slice(($currentPage-1) * $perPage, $perPage)->all();
        $data['results'] = new LengthAwarePaginator($currentPageResults, count($collection), $perPage);
        $data['results']->setPath($request->url());
        $data['sucursales'] = $sucursales;
        $data['categorias'] = $categorias;

        return view('home', compact('sucursales'), $data);
    }
}

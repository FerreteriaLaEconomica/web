<?php

namespace App\Http\Controllers;

use App\Helpers\HttpHelper;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

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
        if ($request->session()->get('message')) {
            return redirect()->route('mostrar-categoria', ['idSucursal' => 1, 'categoria' => 'Descuentos'])
                ->with('messagecompra', 'Compra realizada de forma correcta');
        }
        return redirect()->route('mostrar-categoria', ['idSucursal' => 1, 'categoria' => 'Descuentos']);
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

        $nombreSucursal = '';
        foreach ($sucursales as $ss) {
            if ($ss['id'] == $idSucursal) {
                $nombreSucursal = $ss['nombre'];
                break;
            }
        }
        $productosResponse = $this->httpHelper->get("sucursales/".$idSucursal.'/productos');
        $productos = $productosResponse->json();

        $categoriasResponse = $this->httpHelper->get("categorias");
        $categorias = $categoriasResponse->json();

        $data = array();
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $collection = new Collection($productos);
        $collection = $collection->filter(function ($value, $key) {
            return $value['cantidad'] > 0;
        });
        $perPage = 15;
        $currentPageResults = $collection->slice(($currentPage-1) * $perPage, $perPage)->all();
        $data['results'] = new LengthAwarePaginator($currentPageResults, count($collection), $perPage);
        $data['results']->setPath($request->url());
        $data['sucursales'] = $sucursales;
        $data['categorias'] = $categorias;
        $data['nombreSucursal'] = $nombreSucursal;
        $data['idSucursal'] = $idSucursal;

        return view('home', $data);
    }

    public function verFactura() {
        return Storage::disk('public')->download('/invoices/'.Auth::user()->email.'.pdf');
    }

    public function showByCategory(Request $request, $idSucursal, $categoria) {
        if ($request->session()->get('auth_token') !== null) {
            $user = $request->session()->get('user');
            Auth::login($user);
        }
        $result = $this->httpHelper->get("sucursales");
        $sucursales = $result->json();

        $nombreSucursal = '';
        foreach ($sucursales as $ss) {
            if ($ss['id'] == $idSucursal) {
                $nombreSucursal = $ss['nombre'];
                break;
            }
        }
        $productosResponse = $this->httpHelper->get("sucursales/".$idSucursal.'/productos');
        $productos = $productosResponse->json();

        $categoriasResponse = $this->httpHelper->get("categorias");
        $categorias = $categoriasResponse->json();
        $categorias[] = ['id' => 0, 'nombre' => 'Descuentos'];

        $data = array();
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $collection = new Collection($productos);
        $collection = $collection->filter(function ($value, $key) use ($categoria) {
            if ($categoria == 'Descuentos' && $value['producto']['porcentaje_descuento'] > 0) {
                return $value['cantidad'] > 0;
            }

            $validCategory = $value['producto']['categoria'] == $categoria;
            return $value['cantidad'] > 0 && $validCategory;
        });
        $perPage = 15;
        $currentPageResults = $collection->slice(($currentPage-1) * $perPage, $perPage)->all();
        $data['results'] = new LengthAwarePaginator($currentPageResults, count($collection), $perPage);
        $data['results']->setPath($request->url());
        $data['sucursales'] = $sucursales;
        $data['categorias'] = $categorias;
        $data['nombreSucursal'] = $nombreSucursal;
        $data['nombreCategoria'] = $categoria;
        $data['idSucursal'] = $idSucursal;

        return view('home', $data);
    }
}

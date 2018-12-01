<?php

namespace App\Http\Controllers;

use App\Helpers\HttpHelper;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class CarritoController extends Controller {
    private $httpHelper;

    public function __construct(){
        $this->middleware('custom.auth');
        $this->httpHelper = new HttpHelper();
        if(!\Session::has('carrito')) \Session::put('carrito', array());
    }

    public function show(){
        $carrito = \Session::get('carrito');
        $total = $this->total();
        return view('carrito', compact('carrito', 'total'));
    }

    public function update(Request $request, $id, $cantidad){
        $carrito=\Session::get('carrito');
        $carrito[$id]['cantidad'] = $cantidad;
        \Session::put('carrito', $carrito);

        return redirect()->route('carrito');
    }

    public function add(Request $request, $idSucursal, $idProducto){
        $carrito = \Session::get('carrito');

        $productosResponse = $this->httpHelper->get("sucursales/".$idSucursal.'/productos/'.$idProducto);
        $producto = $productosResponse->json();

        $prod = array();
        $prod['id'] = $producto['id'];
        $prod['id_sucursal'] = $producto['id_sucursal'];
        $prod['id_producto'] = $producto['producto']['id'];
        $prod['nombre'] = $producto['producto']['nombre'];
        $prod['descripcion'] = $producto['producto']['descripcion'];
        $prod['precio'] = $producto['producto']['precio_venta'];
        $prod['url_foto'] = $producto['producto']['url_foto'];
        $prod['porcentaje_descuento'] = $producto['producto']['porcentaje_descuento'];
        $prod['codigo_barras'] = $producto['producto']['codigo_barras'];
        $prod['categoria'] = $producto['producto']['formato'];
        $prod['cantidad'] = 1;

        //$producto->cantidad=1;
        $carrito[$producto['id']] = $prod;
        \Session::put('carrito', $carrito);

        return redirect()->route('carrito');
    }

    private function total(){
        $carrito = \Session::get('carrito');
        $total = 0;
        foreach($carrito as $item){
            $total += $item['precio'] * $item['cantidad'];
        }

        return $total;
    }
}

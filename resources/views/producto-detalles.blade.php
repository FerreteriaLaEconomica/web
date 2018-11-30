@extends('layouts.app')
@section('titulo', 'Lista de Productos')

@section('content')
<div class="container text-center">
    <div class="page-header">
        <h1><i class="fa fa-shopping-cart"></i> Detalle del producto</h1>
    </div>
    <div class="row">

        <div class="col-md-6">
            <div class="producto-block">
                <img src="{{asset($producto['producto']['url_foto'])}}" width="100" height="100">
            </div>
        </div>
        <div class="col-md-6">
            <div class="producto-block">
                <h3>{{$producto['producto']['nombre']}}</h3>
                <hr>
                <div class="producto-info panel">
                    <p>{{$producto['producto']['descripcion']}}</p>
                    <h3>Precio ${{number_format($producto['producto']['precio_venta'], 2)}}</h3>
                    <p>
                        <a href="{{route('carrito-agregar', ['idSucursal' => $producto['id_sucursal'], 'idProducto' => $producto['producto']['id']])}}" class="btn btn-warning">
                            <i class="fa fa-cart-plus fa-2x"></i> Agregar Carrito
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@extends('layouts.app')
@section('titulo', 'Agregados a carrito')

@section('content')
<div class="container text-center">
    <div class="page-header">
        <h1><i class="fa fa-shopping-cart"></i> Productos agregados</h1>
        <hr>
    </div>
    <div class="tabla-carrito">
        @if(count($carrito))
        <div class="table-responsive">
            <table class="table table-black table-striped table-hover table-bordered">
                <thead>
                    <tr>
                        <th>Imagen</th>
                        <th>Producto</th>
                        <th>Precio</th>
                        <th>Cantidad</th>
                        <th>Precio Total</th>
                        <th>Eliminar</th>
                        <th><a href="{{route('login')}}"><i class="fa fa-trash-o fa-3x"></i>Vaciar</a></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($carrito as $item)
                    <tr>
                        <td><img class="w-24 h-24" src="{{$item['url_foto']}}"></td>
                        <td>{{$item['nombre']}}</td>
                        <td>{{number_format($item['precio'], 2)}}</td>
                        <!--                        <td>{{$item['cantidad']}}</td>-->
                        <td>
                            <input type="number" min="1" max="100" value="{{$item['cantidad']}}" id="producto_{{$item['id_producto']}}">

                            <a href="#" class="btn btn-warning btn-update-item" data-href="{{route('carrito-actualizar', $item['id'])}}" data-id="{{$item['id_producto']}}">
                                <i class="fa fa-refresh"></i></a>
                        </td>
                        <td>{{number_format($item['precio'] * $item['cantidad'], 2)}}</td>
                        <td><a href="{{route('login', $item['id_producto'])}}" class="btn btn-danger"><i class="fa fa-remove"></i></a></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <hr>
            <h3>
                <span class="label label-success">Total: ${{number_format($total, 2)}}</span>
            </h3>
        </div>
        @else
        <h3><span class="label label-warning">No existen productos añadidos :'(</span></h3>
        @endif
        <hr>
        <p>
            <a href="{{route('index')}}" class="btn btn-primary"><i class="fa fa-chevron-circle-left"></i> Seguir comprando</a>
            <a href="{{route('login')}}" class="btn btn-warning">Continuar <i class="fa fa-chevron-circle-right"></i></a>
        </p>
    </div>
</div>
@endsection

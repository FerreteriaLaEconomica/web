@extends('layouts.app')
@section('titulo', 'Detalle pedido')

@section('content')
<div class="container text-center">
    <div class="page-header">
        <h1><i class="fa fa-shopping-cart"></i>Detalle del pedido</h1>
    </div>
    <div class="page">
        <div class="table-responsive">
            <h3>Datos del usuario</h3>
            <table class="table table-striped table-hover table-bordered">
                <tr>
                    <td>Nombre: </td>
                    <td>{{Auth::user()->nombre." ".Auth::user()->apellidos}}</td>
                </tr>
                <tr>
                    <td>Dirección: </td>
                    <td>{{Auth::user()->direccion}}</td>
                </tr>
                <tr>
                    <td>Email: </td>
                    <td>{{Auth::user()->email}}</td>
                </tr>
            </table>
        </div>
        <div class="table-responsive">
            <table class="table table-striped table-hover table-bordered">
                <h3>Datos del pedido</h3>
                <tr>
                    <th>Producto</th>
                    <th>Precio</th>
                    <th>Cantidad</th>
                    <th>Subtotal </th>
                </tr>
                @foreach($carrito as $item)
                <tr>
                    <td>{{$item['nombre']}}</td>
                    <td>{{number_format($item['precio'], 2)}}</td>
                    <td>{{$item['cantidad']}}</td>
                    <td>{{number_format($item['precio'] * $item['cantidad'], 2)}}</td>
                </tr>
                @endforeach
                <tr>
                    <td>Costo de envío</td>
                    <td>$ {{ $envio }}</td>
                    <td>1</td>
                    <td>$ {{ $envio }}</td>
                </tr>
            </table>
            <hr>
            <div class="flex flex-row justify-between">
                <p></p>
                <table class="table table-striped table-hover table-bordered w-2/5">
                    <tr>
                        <td>
                            <h3 class="">
                                <span class="text-base text-sm text-soft-black">Subtotal: </span>
                            </h3>
                        </td>
                        <td>
                            <h3 class="">
                                <span class="text-base text-sm text-soft-black"></span>$ {{number_format($subtotal, 2)}}
                            </h3>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <h3 class="">
                                <span class="text-base text-sm text-soft-black">Impuestos (16%): </span>
                            </h3>
                        </td>
                        <td>
                            <h3 class="">
                                <span class="text-base text-sm text-soft-black"></span>$ {{number_format($taxes, 2)}}
                            </h3>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <h1 class="py-2">
                                <span class="text-base text-2xl text-sm text-soft-black">Total: </span>
                            </h1>
                        </td>
                        <td>
                            <h1 class="rounded border py-2">
                                <span class="text-base text-2xl text-sm text-soft-black"></span>$ {{number_format($total, 2)}}
                            </h1>
                        </td>
                    </tr>
                </table>
            </div>
            <hr>
            <p>
                <a href="{{route('carrito')}}" class="btn btn-primary"><i class="fa fa-chevron-circle-left"></i> Regresar</a>
                <a href="{{route('payment')}}" class="btn btn-warning">Pagar con <i class="fab fa-paypal"></i></a>
            </p>
        </div>
    </div>
</div>
@endsection

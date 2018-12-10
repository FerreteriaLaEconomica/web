@extends('layouts.app')

@section('content')

<div class="container">
  <h2 id="textoSucursal">{{ $nombreSucursal }}</h2>
  <div class="row">
    <div class="">
      <div class="content text-center">
        <div class="ex1 px-4 py-1 flex flex-wrap justify-around">
          @foreach($results->items() as $inventario)
            <div class="bump w-64 h-18 m-1 p-2 rounded shadow-md border bg-white white-panel" id="home-panel">
              <h3>{{ $inventario['producto']["nombre"] }}</h3>
              <hr>

              <div class="producto-info panel">
                <img class="h-48" src="{{ $inventario['producto']['url_foto'] }}" alt="">
                <h3><span class="label label-success">Precio: ${{number_format($inventario['producto']['precio_venta'], 2)}}</span></h3>
                @if( $nombreCategoria == 'Descuentos')
                  <p>Descuento: {{ $inventario['producto']['porcentaje_descuento'] }}</p>
                @endif
                <p>
                  <a href="{{ route('carrito-agregar', ['idSucursal' => $inventario['id_sucursal'], 'idProducto' => $inventario['producto']['id']])}}">
                    <button type="button" class="btn btn-warning" id="home-button-add">AGREGAR AL CARRITO</button>
                  </a>
                  <a href="{{ route('producto-detalles', ['idSucursal' => $inventario['id_sucursal'], 'idProducto' => $inventario['producto']['id']]) }}">
                    <button type="button" class="btn btn-success" id="home-button-more">VER MÁS</button>
                  </a>
                </p>
              </div>
              <hr>
            </div>
          @endforeach
          <br>
        </div>
      </div>
      @include('secciones.modal-info')
      <div class="flex justify-center">
      @include('pagination', ['paginator' => $results, 'link_limit' => 3])
      </div>

    </div>

  </div>

</div>
@endsection

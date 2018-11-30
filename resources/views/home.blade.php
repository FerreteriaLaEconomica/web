@extends('layouts.app')

@section('content')

<div class="container">
  <div class="row">
    <div class="col-2">
      @foreach($categorias as $categoria)
        <a href="#">{{$categoria['nombre']}}</a><br>
      @endforeach
    </div>
    <div class="col-10">
      <div class="content text-center">
        <div class="ex1 px-16 py-1 flex flex-wrap justify-around">
          @foreach($results->items() as $inventario)
            <div class="bump w-64 h-18 m-1 p-2 rounded shadow-md border bg-white white-panel">
              <h3>{{ $inventario['producto']["nombre"] }}</h3>
              <hr>

              <div class="producto-info panel">
                <img class="h-48" src="{{ $inventario['producto']['url_foto'] }}" alt="">
                <h3><span class="label label-success">Precio: ${{number_format($inventario['producto']['precio_venta'], 2)}}</span></h3>
                <p>
                  <a href="{{ route('carrito-agregar', ['idSucursal' => $inventario['id_sucursal'], 'idProducto' => $inventario['producto']['id']])}}">
                    <button type="button" class="btn btn-outline-warning">AGREGAR AL CARRITO</button>
                  </a>
                  <a href="{{ route('producto-detalles', ['idSucursal' => $inventario['id_sucursal'], 'idProducto' => $inventario['producto']['id']]) }}">
                    <button type="button" class="btn btn-outline-success">VER MÁS</button>
                  </a>
                </p>
              </div>
              <hr>
            </div>
          @endforeach
          <br>
        </div>
      </div>
      @include('pagination', ['paginator' => $results, 'link_limit' => 3])
    </div>

  </div>

</div>
@endsection

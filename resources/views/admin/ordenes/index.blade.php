@extends('admin.template')

@section('title', 'Productos - Admin')

@section('content')

    <div class="flex justify-between items-center mx-16 my-4">
        <p class="opacity-75 uppercase tracking-wide font-bold text-lg"><i class="fa fa-shopping-basket"></i> Vista principal de Ordenes</p>
    </div>

    <div class="mx-16 my-8">
     <table class="table table-striped table-hover table-bordered">
        <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Email</th>
                <th scope="col">Subtotal</th>
                <th scope="col">Envío</th>
                <th scope="col">Estado orden</th>
                <th scope="col">Fecha</th>
            </tr>
        </thead>
        <tbody>
          @foreach ($ordenes as $producto)
            <tr>
                <th scope="row">{{ $producto->id }}</th>
                <td>{{ $producto->email }}</td>
                <td>{{ $producto->subtotal }}</td>
                <td>$ {{ $producto->envio }}</td>
                <td>{{ $producto->estado_orden }}</td>
                <td>{{ $producto->updated_at }}</td>

            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
@endsection

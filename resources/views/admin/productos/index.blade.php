@extends('admin.template')

@section('title', 'Productos - Admin')

@section('content')

    <div class="flex justify-between items-center mx-16 my-4">
        <p class="opacity-75 uppercase tracking-wide font-bold text-lg"><i class="fa fa-shopping-basket"></i> Vista principal de Productos</p>
        <div>
            <a href="{{ route('reporte.productos') }}" class="btn btn-success">
                Generar reporte <i class="fa fa-print ml-1"></i>
            </a>
            <a href="{{route('productos.create')}}" class="btn btn-warning ml-6">
                Nuevo <i class="fa fa-plus-circle ml-1"></i>
            </a>
        </div>
    </div>

    <div class="mx-16 my-8">
     <table class="table table-striped table-hover table-bordered">
        <thead>
            <tr>
                <th scope="col">Código</th>
                <th scope="col">Nombre</th>
                <th scope="col">Descripción</th>
                <th scope="col">Precio</th>
                <th scope="col"></th>
                <th scope="col"></th>
            </tr>
        </thead>
        <tbody>
          @foreach ($productos as $producto)
            <tr>
                <th scope="row">{{ $producto['codigo_barras'] }}</th>
                <td>{{ $producto['nombre'] }}</td>
                <td>{{ $producto['descripcion'] }}</td>
                <td scope="row" class="text-right">${{ $producto['precio_venta'] }}</td>
                <td>
                    <a href="{{ route('productos.edit', $producto['id']) }}" class="btn btn-default">
                        <i class="fa fa-edit text-blue"></i>
                    </a>
                </td>
                <td>
                    {!! Form::open(array('url' => 'admin/productos/' . $producto['id'], 'class' => 'pull-right')) !!}
                    {!! Form::hidden('_method', 'DELETE') !!}

                    <button type="submit" class="btn btn-default">
                        <i class="fa fa-trash-alt text-red"></i>
                    </button>
                    {!! Form::close() !!}
                </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
@endsection

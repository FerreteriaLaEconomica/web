@extends('admin.template')

@section('title', 'Crear Producto - Admin')

@section('content')

    <p class="opacity-75 uppercase tracking-wide font-bold text-lg text-center mx-16 my-4"><i class="fa fa-shopping-basket"></i> Agregar producto</p>

    {{ Html::ul($errors->all()) }}
    <div>
        <div class="p-4 rounded-b w-full flex justify-center">
          <div class="w-1/3 bg-grey-lightest p-4 shadow-lg">
            {!! Form::open(['route' => 'productos.store', 'files' => true]) !!}
                <div>
                    <label class="text-sm text-soft-black" for="nombre">Nombre</label>
                    {!! Form::text('nombre', null, array(
                        'class' => 'focus:bg-grey-lighter leading-tight appearance-none w-full rounded h-8 border-2 border-primary-lightest',
                        'placeholder' => 'Ingresa el nombre'
                    )) !!}
                </div>
                <div class="my-2">
                    <label class="text-sm text-soft-black" for="descripcion">Descripción</label>
                    {!! Form::text('descripcion', null, array(
                        'class' => 'focus:bg-grey-lighter leading-tight appearance-none w-full rounded h-8 border-2 border-primary-lightest',
                        'placeholder' => 'Ingresa la descripción'
                    )) !!}
                </div>
                <div class="my-2">
                    <label class="text-sm text-soft-black" for="codigo_barras">Código de barras</label>
                    {!! Form::text('codigo_barras', null, array(
                        'class' => 'focus:bg-grey-lighter leading-tight appearance-none w-full rounded h-8 border-2 border-primary-lightest',
                        'placeholder' => 'Ingresa el código barras'
                    )) !!}
                </div>
                <div class="my-2">
                    <label class="text-sm text-soft-black" for="precio">Precio</label>
                    {!! Form::text('precio', null, array(
                        'class' => 'focus:bg-grey-lighter leading-tight appearance-none w-full rounded h-8 border-2 border-primary-lightest',
                        'placeholder' => 'Ingresa el Precio'
                    )) !!}
                </div>
                <div class="my-2">
                    <label class="text-sm text-soft-black" for="precio">Imagen del producto</label>
                    {!! Form::file('url_foto', null) !!}
                </div>
                <div class="my-2">
                    <label class="text-sm text-soft-black" for="categoria">Categoría</label>
                    {!! Form::select('categoria', $categorias, array(
                        'class' => ''
                    )) !!}
                </div>
                <div class="my-2">
                    {!! Form::submit('Guardar', array(
                        'class' => 'rounded bg-primary-light px-4 py-2 cursor-pointer hover:bg-primary'
                    )) !!}
                    <a href="{{ route('productos.index') }}" class="no-underline text-soft-black rounded ml-2 px-4 py-2 hover:bg-grey-light">Cancelar</a>
                </div>
            {!! Form::close() !!}
          </div>
        </div>
    </div>

@endsection

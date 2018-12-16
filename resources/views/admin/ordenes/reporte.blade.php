<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Reporte - Productos</title>
        <style>
            * {
            -webkit-box-sizing: border-box;
            -moz-box-sizing: border-box;
            box-sizing: border-box;
        }


        th,td {
            font-family: DejaVu Sans;
            font-size:16px;
        }

        .panel {
            margin-bottom: 20px;
            background-color: #fff;
            border: 1px solid transparent;
            border-radius: 4px;
            -webkit-box-shadow: 0 1px 1px rgba(0,0,0,.05);
            box-shadow: 0 1px 1px rgba(0,0,0,.05);
        }

        .panel-default {
            border-color: #ddd;
        }

        .panel-body {
            padding: 15px;
        }

        table {
            width: 100%;
            max-width: 100%;
            margin-bottom: 0px;
            border-spacing: 0;
            border-collapse: collapse;
            background-color: transparent;

        }

        thead  {
            text-align: left;
            display: table-header-group;
            vertical-align: middle;
        }

        th, td  {
            border: 1px solid #ddd;
            padding: 6px;
        }

        .well {
            min-height: 20px;
            padding: 19px;
            margin-bottom: 20px;
            background-color: #f5f5f5;
            border: 1px solid #e3e3e3;
            border-radius: 4px;
            -webkit-box-shadow: inset 0 1px 1px rgba(0,0,0,.05);
            box-shadow: inset 0 1px 1px rgba(0,0,0,.05);
        }
            h1,h2,h3,h4,p,span,div { font-family: DejaVu Sans; }
        </style><style>
            h1,h2,h3,h4,p,span,div { font-family: DejaVu Sans; }
        </style>
    </head>
    <body>
        <div id="app">
            <main class="py-4">

            <div class="flex justify-between items-center mx-16 my-4">
        <h1>Reporte de Órdenes</h1>
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
          @foreach ($productos as $producto)
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

            </main>
        </div>
    </body>
</html>

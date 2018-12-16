<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use App\Helpers\HttpHelper;
use Barryvdh\DomPDF\Facade as PDF;
use App\Orden;

class ReportesController extends Controller
{
    private $httpHelper;
    private $token;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->httpHelper = new HttpHelper();
    }

    public function productos(Request $request) {
        $productosResponse = $this->httpHelper->get('productos/');
        $productos = $productosResponse->json();
        $data = [
            'productos' => $productos
        ];
        $pdf = PDF::loadView('admin.productos.reporte', $data);

        return $pdf->download('reporte.pdf');
    }

    public function ordenes(Request $request) {
        $ordenes = Orden::all();
        $data = [
            'productos' => $ordenes
        ];
        $pdf = PDF::loadView('admin.ordenes.reporte', $data);

        return $pdf->download('reporte.pdf');
    }
}

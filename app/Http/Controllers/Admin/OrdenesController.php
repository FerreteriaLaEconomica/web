<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Categoria;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use App\Orden;

class OrdenesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $ordenes = Orden::all();
        return view('admin.ordenes.index', compact('ordenes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        return view('admin.categorias.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $this->validate($request, [
            'nombre' => 'required|unique:categoria|max:255'
        ]);
        Categoria::create([
            'nombre' => $request->get('nombre')
        ]);
        Session::flash('message', 'Categoría creada con éxito!');
        return redirect()->route('categorias.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        $categoria = Categoria::find($id);
        return view('admin.categorias.edit')
            ->with('categoria', $categoria);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        $this->validate($request, [
            'nombre' => 'required|unique:categoria|max:255'
        ]);
        Categoria::find($id)->update([
            'nombre' => $request->get('nombre')
        ]);
        Session::flash('message', 'Categoría actualizada con éxito!');
        return redirect()->route('categorias.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        Categoria::find($id)->delete();
        Session::flash('message', 'Categoría borrada con éxito!');
        return redirect()->route('categorias.index');
    }
}

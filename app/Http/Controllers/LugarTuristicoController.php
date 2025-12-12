<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LugarTuristico;
use App\Models\Provincia;
use App\Models\TipoAtraccion;

class LugarTuristicoController extends Controller
{
    public function index()
    {
        $lugares = LugarTuristico::orderBy('id_lugar', 'asc')->get();
        return view('lugar_turistico.index', compact('lugares'));
    }

    public function create()
    {
        $provincias = Provincia::orderBy('nombre_provincia', 'asc')->get();
        $tipos = TipoAtraccion::orderBy('nombre_tipo', 'asc')->get();
        return view('lugar_turistico.create', compact('provincias', 'tipos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre_lugar'     => 'required|string|max:200|unique:lugar_turisticos,nombre_lugar',
            'id_provincia'     => 'required|exists:provincia,id_provincia',
            'id_tipo'          => 'required|exists:tipo_atraccions,id_tipo',
            'latitud'          => 'required|numeric',
            'longitud'         => 'required|numeric',
            'descripcion'      => 'nullable|string',
            'anio_creacion'    => 'nullable|string|max:10',
            'accesibilidad'    => 'nullable|string|max:50',
        ]);

        LugarTuristico::create($request->all());

        return redirect()->route('lugar_turistico.index')
            ->with('success', 'Lugar turístico creado correctamente.');
    }

    // Mostrar formulario para editar un lugar turístico existente
    public function edit($id)
    {
        $lugar = LugarTuristico::findOrFail($id);
        $provincias = Provincia::orderBy('nombre_provincia', 'asc')->get();
        $tipos = TipoAtraccion::orderBy('nombre_tipo', 'asc')->get();
        return view('lugar_turistico.edit', compact('lugar', 'provincias', 'tipos'));
    }

    public function update(Request $request, $id)
    {
        $lugar = LugarTuristico::findOrFail($id);

        $request->validate([
            'nombre_lugar'     => 'required|string|max:200|unique:lugar_turisticos,nombre_lugar,' . $lugar->id_lugar . ',id_lugar',
            'id_provincia'     => 'required|exists:provincia,id_provincia',
            'id_tipo'          => 'required|exists:tipo_atraccions,id_tipo',
            'latitud'          => 'required|numeric',
            'longitud'         => 'required|numeric',
            'descripcion'      => 'nullable|string',
            'anio_creacion'    => 'nullable|string|max:10',
            'accesibilidad'    => 'nullable|string|max:50',
        ]);

        $lugar->update($request->all());

        return redirect()->route('lugar_turistico.index')
            ->with('success', 'Lugar turístico actualizado correctamente.');
    }

    public function destroy($id)
    {
        $lugar = LugarTuristico::findOrFail($id);



        $lugar->delete();

        return redirect()->route('lugar_turistico.index')
            ->with('success', 'Lugar turístico eliminado correctamente.');
    }

}

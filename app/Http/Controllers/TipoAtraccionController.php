<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TipoAtraccion;

class TipoAtraccionController extends Controller
{
    /**
     * Mostrar todos los tipos de atracción
     */
    public function index()
    {
        $tipos = TipoAtraccion::orderBy('id_tipo', 'asc')->get();
        return view('tipo_atraccion.index', compact('tipos'));
    }

    /**
     * Mostrar el formulario para crear un nuevo tipo de atracción
     */
    public function create()
    {
        return view('tipo_atraccion.create');
    }

    /**
     * Guardar un nuevo tipo de atracción en la base de datos
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre_tipo' => 'required|string|max:100|unique:tipo_atraccions,nombre_tipo',
        ]);

        TipoAtraccion::create([
            'nombre_tipo' => $request->nombre_tipo
        ]);

        return redirect()->route('tipo_atraccion.index')
                         ->with('success', 'Tipo de atracción creada correctamente.');
    }

    /**
     * Mostrar el formulario para editar un tipo de atracción existente
     */
    public function edit($id)
    {
        $tipo = TipoAtraccion::findOrFail($id);
        return view('tipo_atraccion.edit', compact('tipo'));
    }

    /**
     * Actualizar un tipo de atracción existente
     */
    public function update(Request $request, $id)
    {
        $tipo = TipoAtraccion::findOrFail($id);

        $request->validate([
            'nombre_tipo' => 'required|string|max:100|unique:tipo_atraccions,nombre_tipo,' . $tipo->id_tipo . ',id_tipo',
        ]);

        $tipo->update([
            'nombre_tipo' => $request->nombre_tipo
        ]);

        return redirect()->route('tipo_atraccion.index')
                         ->with('success', 'Tipo de atracción actualizado correctamente.');
    }


    public function destroy($id)
    {
        $tipo = TipoAtraccion::findOrFail($id);

        if ($tipo->lugares()->count() > 0) {
            return back()->with('error',
                'No se puede eliminar este tipo de atracción porque está asociado a lugares turísticos.');
        }

        $tipo->delete();

        return redirect()->route('tipo_atraccion.index')
                        ->with('success', 'Tipo de atracción eliminado correctamente.');
    }



}

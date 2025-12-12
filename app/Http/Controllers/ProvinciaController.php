<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Provincia;

class ProvinciaController extends Controller
{
    public function index()
    {
        $provincias = Provincia::orderBy('id_provincia', 'asc')->get();
        return view('provincias.index', compact('provincias'));
    }

    public function create()
    {
        return view('provincias.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre_provincia' => 'required|string|max:100|unique:provincia,nombre_provincia',
        ]);

        Provincia::create([
            'nombre_provincia' => $request->nombre_provincia
        ]);

        return redirect()->route('provincias.index')
            ->with('success', 'Provincia creada correctamente.');
    }

    public function edit($id)
    {
        $provincia = Provincia::findOrFail($id);
        return view('provincias.edit', compact('provincia'));
    }

    public function update(Request $request, $id)
    {
        $provincia = Provincia::findOrFail($id);

        $request->validate([
            'nombre_provincia' => 'required|string|max:100|unique:provincia,nombre_provincia,' . $provincia->id_provincia . ',id_provincia',
        ]);

        $provincia->update([
            'nombre_provincia' => $request->nombre_provincia
        ]);

        return redirect()->route('provincias.index')
            ->with('success', 'Provincia actualizada correctamente.');
    }

    public function destroy($id)
    {
    $provincia = Provincia::findOrFail($id);

    if ($provincia->lugares()->count() > 0) {
        return back()->with('error',);
    }

    $provincia->delete();

    return redirect()->route('provincias.index')
        ->with('success', 'Provincia eliminada correctamente.');
    }


}

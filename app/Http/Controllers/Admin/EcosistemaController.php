<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreEcosistemaRequest;
use App\Http\Requests\UpdateEcosistemaRequest;
use App\Models\Ecosistema;
use Illuminate\Http\Request;

class EcosistemaController extends Controller
{
    public function index()
    {
        $ecosistemas = Ecosistema::paginate(10);

        return view('admin.ecosistemas.index', compact('ecosistemas'));
    }

    public function create()
    {
        return view('admin.ecosistemas.create');
    }

    public function store(StoreEcosistemaRequest $request)
    {
        Ecosistema::create($request->validated());

        return redirect()->route('admin.ecosistema.index')->with('success', 'Ecosistema creado');
    }

    public function show(Ecosistema $ecosistema)
    {
        return view('admin.ecosistemas.show', compact('ecosistema'));
    }

    public function edit(Ecosistema $ecosistema)
    {
        return view('admin.ecosistemas.edit', compact('ecosistema'));
    }

    public function update(UpdateEcosistemaRequest $request, Ecosistema $ecosistema)
    {
        $ecosistema->update($request->validated());

        return redirect()->route('admin.ecosistema.index')->with('success', 'Ecosistema actualizado');
    }

    public function destroy(Ecosistema $ecosistema)
    {
        $ecosistema->delete();

        return redirect()->route('admin.ecosistema.index')->with('success', 'Ecosistema eliminado');
    }
}

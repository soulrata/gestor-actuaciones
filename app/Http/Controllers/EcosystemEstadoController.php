<?php

namespace App\Http\Controllers;

use App\Models\Estado;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class EcosystemEstadoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $currentUser = Auth::user();
        
        if (!$currentUser->ecosistema_id) {
            abort(403, 'Debes estar asignado a un ecosistema para gestionar estados.');
        }

        $estados = Estado::where('ecosistema_id', $currentUser->ecosistema_id)
            ->with('ecosistema')
            ->orderBy('tipo')
            ->orderBy('nombre')
            ->paginate(10);

        return view('ecosystem.estados.index', compact('estados'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $currentUser = Auth::user();
        
        if (!$currentUser->ecosistema_id) {
            abort(403, 'Debes estar asignado a un ecosistema.');
        }

        $tipos = Estado::getTipos();

        return view('ecosystem.estados.create', compact('tipos'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $currentUser = Auth::user();
        
        if (!$currentUser->ecosistema_id) {
            abort(403, 'Debes estar asignado a un ecosistema.');
        }

        // DEBUG: Mostrar datos del request
        Log::info('=== ECOSYSTEM ESTADO STORE DEBUG ===');
        Log::info('Current User ID: ' . $currentUser->id);
        Log::info('Current User Ecosistema ID: ' . $currentUser->ecosistema_id);
        Log::info('Request Nombre: ' . $request->input('nombre'));
        Log::info('Request Tipo: ' . $request->input('tipo'));
        Log::info('Request All Data: ' . json_encode($request->all()));

        $request->validate([
            'nombre' => 'required|string|max:255',
            'tipo' => 'required|in:Inicio,En Proceso,Fin',
        ]);

        // Verificar que no existe otro estado con el mismo nombre en el ecosistema
        $existingEstado = Estado::where('ecosistema_id', $currentUser->ecosistema_id)
            ->where('nombre', $request->nombre)
            ->first();

        if ($existingEstado) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Ya existe un estado con ese nombre en tu ecosistema.');
        }

        Log::info('Creating estado with data:');
        Log::info('- Nombre: ' . $request->nombre);
        Log::info('- Tipo: ' . $request->tipo);
        Log::info('- Ecosistema ID: ' . $currentUser->ecosistema_id);

        try {
            $estado = Estado::create([
                'nombre' => $request->nombre,
                'tipo' => $request->tipo,
                'ecosistema_id' => $currentUser->ecosistema_id,
            ]);

            Log::info('Estado created successfully with ID: ' . $estado->id);
            Log::info('=== END ESTADO STORE DEBUG ===');

            return redirect()->route('ecosystem.estados.index')
                ->with('success', 'Estado creado exitosamente.');

        } catch (\Exception $e) {
            Log::error('Error creating estado: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            Log::info('=== END ESTADO STORE DEBUG (ERROR) ===');
            
            return redirect()->back()
                ->withInput()
                ->with('error', 'Error al crear estado: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Estado $estado)
    {
        $currentUser = Auth::user();
        
        // Verificar que el estado pertenece al mismo ecosistema
        if ($estado->ecosistema_id !== $currentUser->ecosistema_id) {
            abort(403, 'No puedes ver estados de otros ecosistemas.');
        }

        $estado->load('ecosistema');

        return view('ecosystem.estados.show', compact('estado'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Estado $estado)
    {
        $currentUser = Auth::user();
        
        // Verificar que el estado pertenece al mismo ecosistema
        if ($estado->ecosistema_id !== $currentUser->ecosistema_id) {
            abort(403, 'No puedes editar estados de otros ecosistemas.');
        }

        $tipos = Estado::getTipos();

        return view('ecosystem.estados.edit', compact('estado', 'tipos'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Estado $estado)
    {
        $currentUser = Auth::user();
        
        // Verificar que el estado pertenece al mismo ecosistema
        if ($estado->ecosistema_id !== $currentUser->ecosistema_id) {
            abort(403, 'No puedes editar estados de otros ecosistemas.');
        }

        // DEBUG: Mostrar datos del request
        Log::info('=== ECOSYSTEM ESTADO UPDATE DEBUG ===');
        Log::info('Estado ID: ' . $estado->id);
        Log::info('Estado Nombre: ' . $estado->nombre);
        Log::info('Request Nombre: ' . $request->input('nombre'));
        Log::info('Request Tipo: ' . $request->input('tipo'));
        Log::info('Request All Data: ' . json_encode($request->all()));

        $request->validate([
            'nombre' => 'required|string|max:255',
            'tipo' => 'required|in:Inicio,En Proceso,Fin',
        ]);

        // Verificar que no existe otro estado con el mismo nombre en el ecosistema (excepto el actual)
        $existingEstado = Estado::where('ecosistema_id', $currentUser->ecosistema_id)
            ->where('nombre', $request->nombre)
            ->where('id', '!=', $estado->id)
            ->first();

        if ($existingEstado) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Ya existe otro estado con ese nombre en tu ecosistema.');
        }

        try {
            $estado->update([
                'nombre' => $request->nombre,
                'tipo' => $request->tipo,
            ]);

            Log::info('Estado updated successfully');
            Log::info('=== END ESTADO UPDATE DEBUG ===');

            return redirect()->route('ecosystem.estados.index')
                ->with('success', 'Estado actualizado exitosamente.');

        } catch (\Exception $e) {
            Log::error('Error updating estado: ' . $e->getMessage());
            Log::info('=== END ESTADO UPDATE DEBUG (ERROR) ===');
            
            return redirect()->back()
                ->withInput()
                ->with('error', 'Error al actualizar estado: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Estado $estado)
    {
        $currentUser = Auth::user();
        
        // Verificar que el estado pertenece al mismo ecosistema
        if ($estado->ecosistema_id !== $currentUser->ecosistema_id) {
            abort(403, 'No puedes eliminar estados de otros ecosistemas.');
        }

        // TODO: Verificar si está siendo usado en secuencias/pasos antes de eliminar
        // if ($estado->pasos()->count() > 0) {
        //     return redirect()->route('ecosystem.estados.index')
        //         ->with('error', 'No puedes eliminar un estado que está siendo usado en secuencias.');
        // }

        try {
            $estado->delete();

            return redirect()->route('ecosystem.estados.index')
                ->with('success', 'Estado eliminado exitosamente.');

        } catch (\Exception $e) {
            return redirect()->route('ecosystem.estados.index')
                ->with('error', 'Error al eliminar estado: ' . $e->getMessage());
        }
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Secuencia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class EcosystemSecuenciaController extends Controller
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
            abort(403, 'Debes estar asignado a un ecosistema para gestionar secuencias.');
        }

        $secuencias = Secuencia::where('ecosistema_id', $currentUser->ecosistema_id)
            ->with('ecosistema')
            ->orderBy('activa', 'desc')
            ->orderBy('nombre')
            ->paginate(10);

        return view('ecosystem.secuencias.index', compact('secuencias'));
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

        return view('ecosystem.secuencias.create');
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
        Log::info('=== ECOSYSTEM SECUENCIA STORE DEBUG ===');
        Log::info('Current User ID: ' . $currentUser->id);
        Log::info('Current User Ecosistema ID: ' . $currentUser->ecosistema_id);
        Log::info('Request Nombre: ' . $request->input('nombre'));
        Log::info('Request Descripcion: ' . $request->input('descripcion'));
        Log::info('Request Activa: ' . $request->input('activa'));
        Log::info('Request All Data: ' . json_encode($request->all()));

        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string|max:1000',
            'activa' => 'boolean',
        ]);

        // Verificar que no existe otra secuencia con el mismo nombre en el ecosistema
        $existingSecuencia = Secuencia::where('ecosistema_id', $currentUser->ecosistema_id)
            ->where('nombre', $request->nombre)
            ->first();

        if ($existingSecuencia) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Ya existe una secuencia con ese nombre en tu ecosistema.');
        }

        Log::info('Creating secuencia with data:');
        Log::info('- Nombre: ' . $request->nombre);
        Log::info('- Descripcion: ' . ($request->descripcion ?? 'NULL'));
        Log::info('- Activa: ' . ($request->boolean('activa') ? 'true' : 'false'));
        Log::info('- Ecosistema ID: ' . $currentUser->ecosistema_id);

        try {
            $secuencia = Secuencia::create([
                'nombre' => $request->nombre,
                'descripcion' => $request->descripcion,
                'activa' => $request->boolean('activa', true),
                'ecosistema_id' => $currentUser->ecosistema_id,
            ]);

            Log::info('Secuencia created successfully with ID: ' . $secuencia->id);
            Log::info('=== END SECUENCIA STORE DEBUG ===');

            return redirect()->route('ecosystem.secuencias.index')
                ->with('success', 'Secuencia creada exitosamente.');

        } catch (\Exception $e) {
            Log::error('Error creating secuencia: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            Log::info('=== END SECUENCIA STORE DEBUG (ERROR) ===');
            
            return redirect()->back()
                ->withInput()
                ->with('error', 'Error al crear secuencia: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Secuencia $secuencia)
    {
        $currentUser = Auth::user();
        
        // Verificar que la secuencia pertenece al mismo ecosistema
        if ($secuencia->ecosistema_id !== $currentUser->ecosistema_id) {
            abort(403, 'No puedes ver secuencias de otros ecosistemas.');
        }

        $secuencia->load('ecosistema');

        return view('ecosystem.secuencias.show', compact('secuencia'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Secuencia $secuencia)
    {
        $currentUser = Auth::user();
        
        // Verificar que la secuencia pertenece al mismo ecosistema
        if ($secuencia->ecosistema_id !== $currentUser->ecosistema_id) {
            abort(403, 'No puedes editar secuencias de otros ecosistemas.');
        }

        return view('ecosystem.secuencias.edit', compact('secuencia'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Secuencia $secuencia)
    {
        $currentUser = Auth::user();
        
        // Verificar que la secuencia pertenece al mismo ecosistema
        if ($secuencia->ecosistema_id !== $currentUser->ecosistema_id) {
            abort(403, 'No puedes editar secuencias de otros ecosistemas.');
        }

        // DEBUG: Mostrar datos del request
        Log::info('=== ECOSYSTEM SECUENCIA UPDATE DEBUG ===');
        Log::info('Secuencia ID: ' . $secuencia->id);
        Log::info('Secuencia Nombre: ' . $secuencia->nombre);
        Log::info('Request Nombre: ' . $request->input('nombre'));
        Log::info('Request Descripcion: ' . $request->input('descripcion'));
        Log::info('Request Activa: ' . $request->input('activa'));
        Log::info('Request All Data: ' . json_encode($request->all()));

        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string|max:1000',
            'activa' => 'boolean',
        ]);

        // Verificar que no existe otra secuencia con el mismo nombre en el ecosistema (excepto la actual)
        $existingSecuencia = Secuencia::where('ecosistema_id', $currentUser->ecosistema_id)
            ->where('nombre', $request->nombre)
            ->where('id', '!=', $secuencia->id)
            ->first();

        if ($existingSecuencia) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Ya existe otra secuencia con ese nombre en tu ecosistema.');
        }

        try {
            $secuencia->update([
                'nombre' => $request->nombre,
                'descripcion' => $request->descripcion,
                'activa' => $request->boolean('activa', true),
            ]);

            Log::info('Secuencia updated successfully');
            Log::info('=== END SECUENCIA UPDATE DEBUG ===');

            return redirect()->route('ecosystem.secuencias.index')
                ->with('success', 'Secuencia actualizada exitosamente.');

        } catch (\Exception $e) {
            Log::error('Error updating secuencia: ' . $e->getMessage());
            Log::info('=== END SECUENCIA UPDATE DEBUG (ERROR) ===');
            
            return redirect()->back()
                ->withInput()
                ->with('error', 'Error al actualizar secuencia: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Secuencia $secuencia)
    {
        $currentUser = Auth::user();
        
        // Verificar que la secuencia pertenece al mismo ecosistema
        if ($secuencia->ecosistema_id !== $currentUser->ecosistema_id) {
            abort(403, 'No puedes eliminar secuencias de otros ecosistemas.');
        }

        // TODO: Verificar si está siendo usada en pasos antes de eliminar
        // if ($secuencia->pasos()->count() > 0) {
        //     return redirect()->route('ecosystem.secuencias.index')
        //         ->with('error', 'No puedes eliminar una secuencia que tiene pasos configurados.');
        // }

        try {
            $secuencia->delete();

            return redirect()->route('ecosystem.secuencias.index')
                ->with('success', 'Secuencia eliminada exitosamente.');

        } catch (\Exception $e) {
            return redirect()->route('ecosystem.secuencias.index')
                ->with('error', 'Error al eliminar secuencia: ' . $e->getMessage());
        }
    }
}

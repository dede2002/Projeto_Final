<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Psicologo;
use App\Models\Sessao;

class DashboardController extends Controller
{
    public function secretaria()
    {
        $user = Auth::user();
        if ($user && $user->role === 'secretaria') {
            $clients = User::where('role', 'cliente')->get();
            $appointments = Sessao::with(['client', 'psychologist'])->orderBy('session_date')->get();
            return Inertia::render('Secretaria/dashboard', [
                'clients' => $clients,
                'sessions' => $appointments, // Passando sessões para a view
            ]);
        }
        return redirect()->route('login')->withErrors(['message' => 'Acesso não autorizado.']);
    }

    public function psicologo()
    {
        $user = Auth::user();
        if ($user && $user->role === 'psicologo') {
            $sessoes = Sessao::where('psychologist_id', $user->id)
                ->with('client')
                ->orderBy('session_date', 'asc')
                ->get();
            return Inertia::render('Psicologos/dashboard', ['sessions' => $sessoes]);
        }
        return redirect()->route('login')->withErrors(['message' => 'Acesso não autorizado.']);
    }

    public function cliente()
    {
        $user = Auth::user();
        if ($user && $user->role === 'cliente') {
            $sessoes = Sessao::where('client_id', $user->id)->with('psychologist')->get();
            return Inertia::render('Clientes/dashboard', ['sessions' => $sessoes]);
        }
        return redirect()->route('login')->withErrors(['message' => 'Acesso não autorizado.']);
    }

    public function announceArrival(Request $request)
    {
        $request->validate([
            'client_id' => 'required|exists:users,id',
            'psychologist_id' => 'required|exists:users,id',
        ]);

        $sessao = Sessao::create([
            'client_id' => $request->client_id,
            'psychologist_id' => $request->psychologist_id,
            'session_date' => now(),
            'notes' => ''
        ]);

        return response()->json(['message' => 'Notificação enviada com sucesso.']);
    }
    
    public function getPsychologists()
    {
        $psychologists = Psicologo::with('user')->get();
        return response()->json($psychologists);
    }
}

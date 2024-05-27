<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sessao;
use Inertia\Inertia;

class SessaoController extends Controller
{
    public function index()
    {
        $sessions = Sessao::with(['client.user', 'psychologist.user'])->orderBy('session_date')->get();
        return Inertia::render('Secretaria/Sessoes', [
            'sessions' => $sessions,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'client_id' => 'required|exists:users,id',
            'psychologist_id' => 'required|exists:users,id',
            'session_date' => 'required|date',
            'session_time' => 'required|date_format:H:i',
        ]);

        $sessionDateTime = date('Y-m-d H:i:s', strtotime("$validated[session_date] $validated[session_time]"));

        $session = Sessao::create([
            'client_id' => $validated['client_id'],
            'psychologist_id' => $validated['psychologist_id'],
            'session_date' => $sessionDateTime,
        ]);

        return redirect()->route('secretaria.dashboard')->with('success', 'Sessão agendada com sucesso.');
    }

    public function edit($id)
    {
        $session = Sessao::with('client')->findOrFail($id);
        $client = $session->client;
    
        return inertia('Psicologos/editar', [
            'session' => $session,
            'client' => $client,
            'sessions' => Sessao::where('client_id', $client->id)->get(),
        ]);
    }

    public function show($id)
    {
        $session = Sessao::with('client', 'psychologist', 'sessoes')->findOrFail($id);

        return Inertia::render('Clientes/Notas-Medicas', [
            'session' => $session,
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'notes' => 'nullable|string',
            'restricted_info' => 'nullable|string',
        ]);

        $session = Sessao::findOrFail($id);
        $session->update([
            'session_date' => now(),
            'notes' => $request->notes,
            'restricted_info' => $request->restricted_info,
        ]);

        return redirect()->route('psicologo.dashboard')->with('success', 'Sessão atualizada com sucesso.');
    }

    public function announceArrival(Request $request)
    {
        $request->validate([
            'session_id' => 'required|exists:sessoes,id',
        ]);

        $session = Sessao::findOrFail($request->session_id);
        $session->client_arrived = true;
        $session->save();

        return response()->json(['message' => 'Anúncio de chegada registrado com sucesso.']);
    }

    public function storeAppointment(Request $request)
    {
        // Validação dos dados
        $request->validate([
            'client_id' => 'required|exists:users,id',
            'psychologist_id' => 'required|exists:users,id',
            'session_date' => 'required|date',
            'session_time' => 'required|date_format:H:i',
        ]);
    
        // Combinando a data e a hora da sessão em um único DateTime
        $sessionDateTime = date('Y-m-d H:i:s', strtotime("$request->session_date $request->session_time"));
    
        // Verificar se já existe uma sessão marcada para o cliente no mesmo horário
        $existingSession = Sessao::where('psychologist_id', $request->psychologist_id)
            ->where('session_date', $sessionDateTime)
            ->first();
    
        // Se já existir uma sessão, retornar um erro
        if ($existingSession) {
            return redirect()->route('secretaria.dashboard')->with('error', 'Já existe uma sessão marcada para este cliente neste horário.');

        }
    
        // Criar a sessão se não houver conflitos
        Sessao::create([
            'client_id' => $request->client_id,
            'psychologist_id' => $request->psychologist_id,
            'session_date' => $sessionDateTime,
        ]);
    
        // Redirecionar com mensagem de sucesso
        return redirect()->route('secretaria.dashboard')->with('success', 'Consulta marcada com sucesso.');
    }

    public function finishSession(Request $request)
    {
        $request->validate([
            'session_id' => 'required|exists:sessoes,id',
        ]);

        $session = Sessao::findOrFail($request->session_id);
        $session->client_arrived = 2;  // Define como sessão finalizada
        $session->save();

        return response()->json(['message' => 'Sessão finalizada com sucesso.']);
    }

    public function getAppointmentsForPsychologist(Request $request)
    {
        $appointments = Sessao::with(['client.user', 'psychologist.user'])
            ->where('psychologist_id', $request->user()->id)
            ->orderBy('session_date')
            ->get();

        $appointments = $appointments->map(function ($appointment) {
            return [
                'id' => $appointment->id,
                'session_date' => $appointment->session_date,
                'notes' => $appointment->notes,
                'client_arrived' => $appointment->client_arrived,
                'client' => $appointment->client ? $appointment->client->user->only(['name', 'email', 'phone']) : null,
                'psychologist' => $appointment->psychologist ? $appointment->psychologist->user->only(['name']) : null,
            ];
        });

        return response()->json($appointments);
    }
    public function atestados($id) // Corrigir o tipo de parâmetro
    {
        $session = Sessao::with(['client', 'psychologist'])->find($id); // Carregar relações corretas

        if (!$session) {
            return response()->json(['error' => 'Sessão não encontrada'], 404);
        }

        return response()->json([
            'client' => $session->client,
            'psychologist' => $session->psychologist,
            'session_date' => $session->session_date,
        ]);
    }

    public function abrirAtestado(){
        return Inertia::render('Atestados');
    }
    
    public function cancelSession($id)
    {
        $session = Sessao::find($id);

        if (!$session) {
            return response()->json(['error' => 'Sessão não encontrada'], 404);
        }

        $session->delete();

        return response()->json(['success' => 'Sessão cancelada com sucesso'], 200);
    }
}

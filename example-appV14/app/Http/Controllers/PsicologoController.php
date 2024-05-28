<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Psicologo;
use App\Models\Sessao;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;

class PsicologoController extends Controller
{
    // Receber aviso que o próximo paciente chegou e está aguardando
    public function avisos()
    {
        $psicologo = Auth::user();
        // Aqui você pode buscar na base de dados os avisos para este psicólogo
        $avisos = Aviso::where('psicologo_id', $psicologo->id)->get();

        return Inertia::render('Psicologo/Avisos', ['avisos' => $avisos]);
    }

    // Abrir a ficha de um paciente para ler e editar
    public function abrirFicha($cliente_id)
    {
        $psicologo = Auth::user();
        $cliente = Cliente::findOrFail($cliente_id);
        // Você também pode buscar as sessões e documentos relacionados ao cliente
        $sessoes = Sessao::where('cliente_id', $cliente_id)->get();

        return Inertia::render('Psicologo/Ficha', [
            'cliente' => $cliente,
            'sessoes' => $sessoes,
            'documentos' => [
                'encaminhamentos' => Documento::where('cliente_id', $cliente_id)->where('tipo', 'encaminhamento')->get(),
                'atestados' => Documento::where('cliente_id', $cliente_id)->where('tipo', 'atestado')->get(),
            ],
        ]);
    }

    // Salvar informações da sessão
    public function salvarSessao(Request $request, $cliente_id)
    {
        $psicologo = Auth::user();
        $request->validate([
            'sessao_data' => 'required|date',
            'descricao' => 'required|string',
        ]);

        Sessao::create([
            'cliente_id' => $cliente_id,
            'psicologo_id' => $psicologo->id,
            'sessao_data' => $request->sessao_data,
            'descricao' => $request->descricao,
        ]);

        return redirect()->back()->with('success', 'Informações da sessão salvas com sucesso.');
    }

    // Salvar documentos padrões
    public function salvarDocumento(Request $request, $cliente_id, $tipo)
    {
        $request->validate([
            'conteudo' => 'required|string',
        ]);

        Documento::updateOrCreate(
            ['cliente_id' => $cliente_id, 'tipo' => $tipo],
            ['conteudo' => $request->conteudo]
        );

        return redirect()->back()->with('success', 'Documento salvo com sucesso.');
    }
}

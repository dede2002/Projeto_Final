<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Psicologo;
use App\Models\Secretaria;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Illuminate\Http\RedirectResponse;

class UserController extends Controller
{
    public function create()
    {
        $user = Auth::user();
        if ($user && $user->role === 'secretaria') {
            return inertia('Secretaria/CadastroUsuario');
        }
    }

    public function storeClient(Request $request)
    {
        $this->storeUser($request, 'cliente');
    }

    public function storePsicologo(Request $request)
    {
        $this->storeUser($request, 'psicologo');
    }

    public function storeSecretaria(Request $request)
    {
        $this->storeUser($request, 'secretaria');
    }

    private function storeUser(Request $request, $role)
    {
        Log::info('Iniciando o processo de armazenamento de um novo usuário.');

        // Validando os dados recebidos
        $validated = $request->validate($this->validationRules($role));

        Log::info('Dados validados com sucesso.', ['validated' => $validated]);

        // Criando o usuário
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => $role,
        ]);

        Log::info('Usuário criado com sucesso.', ['user_id' => $user->id]);

        // Criando o tipo específico de usuário
        switch ($role) {
            case 'cliente':
                Client::create($this->clientData($validated, $user->id));
                Log::info('Cliente criado com sucesso.');
                break;
            case 'psicologo':
                Psicologo::create($this->psicologoData($validated, $user->id));
                Log::info('Psicólogo criado com sucesso.');
                break;
            case 'secretaria':
                Secretaria::create($this->secretariaData($validated, $user->id));
                Log::info('Secretária criada com sucesso.');
                break;
        }

        Log::info('Processo de armazenamento de usuário concluído com sucesso.');

        return redirect()->route('secretaria.dashboard');
    }

    private function validationRules($role)
    {
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|string|max:255|unique:users,email',
            'password' => 'required|string|min:8',
        ];

        switch ($role) {
            case 'cliente':
                $rules = array_merge($rules, [
                    'cep' => 'required|string|max:9',
                    'logradouro' => 'required|string|max:255',
                    'bairro' => 'required|string|max:255',
                    'cidade' => 'required|string|max:255',
                    'estado' => 'required|string|max:2',
                    'telefone' => 'required|string|max:15',
                ]);
                break;
            case 'psicologo':
                $rules = array_merge($rules, [
                    'crm' => 'required|string|max:255',
                    'telefone' => 'required|string|max:15',
                ]);
                break;
            case 'secretaria':
                $rules = array_merge($rules, [
                    'telefone' => 'required|string|max:15',
                ]);
                break;
        }

        return $rules;
    }

    private function clientData($validated, $user_id)
    {
        return [
            'user_id' => $user_id,
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'cep' => $validated['cep'],
            'logradouro' => $validated['logradouro'],
            'bairro' => $validated['bairro'],
            'cidade' => $validated['cidade'],
            'estado' => $validated['estado'],
            'telefone' => $validated['telefone'],
        ];
    }

    private function psicologoData($validated, $user_id)
    {
        return [
            'user_id' => $user_id,
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'crm' => $validated['crm'],
            'telefone' => $validated['telefone'],
        ];
    }

    private function secretariaData($validated, $user_id)
    {
        return [
            'user_id' => $user_id,
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'telefone' => $validated['telefone'],
        ];
    }
}

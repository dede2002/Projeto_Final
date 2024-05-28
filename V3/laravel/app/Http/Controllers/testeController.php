<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Secretaria; // Certifique-se de importar o modelo Secretaria


class testeController extends Controller
{

    public function storeSecretaria(Request $request)
    {
        $this->storeUser($request, 'secretaria');
    }

    public function storeUser(Request $request, $role)
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

        Secretaria::create($this->secretariaData($validated, $user->id));
                Log::info('Secretária criada com sucesso.');
        // Criando o tipo específico de usuário

        Log::info('Processo de armazenamento de usuário concluído com sucesso.');

        return redirect()->route('welcome');
    }

}

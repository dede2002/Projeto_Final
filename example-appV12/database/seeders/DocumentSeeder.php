<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Document;

class DocumentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $documents = [
            [
                'name' => 'Atestado Médico',
                'fields' => [
                    ['name' => 'client_name', 'label' => 'Nome do Paciente'],
                    ['name' => 'session_date', 'label' => 'Data da Sessão'],
                ],
            ],
            [
                'name' => 'Encaminhamento',
                'fields' => [
                    ['name' => 'client_name', 'label' => 'Nome do Paciente'],
                    ['name' => 'doctor_name', 'label' => 'Nome do Médico'],
                    ['name' => 'reason', 'label' => 'Motivo'],
                ],
            ],
        ];

        foreach ($documents as $document) {
            Document::create($document);
        }
    }
}

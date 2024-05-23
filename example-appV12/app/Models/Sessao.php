<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sessao extends Model
{
    use HasFactory;

    protected $table = 'sessoes'; // Definindo o nome da tabela explicitamente

    protected $fillable = [
        'client_id',
        'psychologist_id',
        'session_date',
        'notes',
        'restricted_info'
    ];

    public function client()
    {
        return $this->belongsTo(User::class, 'client_id');
    }

    public function psychologist()
    {
        return $this->belongsTo(User::class, 'psychologist_id');
    }
    public function sessoes()
    {
        return $this->belongsTo(User::class, 'id');
    }
}

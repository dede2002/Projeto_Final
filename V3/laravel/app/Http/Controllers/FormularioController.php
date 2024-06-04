<?php

namespace App\Http\Controllers;

use App\Mail\Formulario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class FormularioController extends Controller
{
    public function index() {
        
        return back();

    }

    public function store(Request $request) 
    {
        
            Mail::to('contato@duhaclinica.com', 'Joueph')->send(new Formulario([    

            'fromName'=> $request -> input('name'), 
            'fromEmail'=> $request -> input('email'),
            'message'=> $request -> input('message'),

        ]));

        return back();

    }
}
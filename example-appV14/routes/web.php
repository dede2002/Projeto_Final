<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SessaoController;
use App\Http\Controllers\PsicologoController;
use App\Http\Controllers\DocumentController;
use Illuminate\Foundation\Application;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
        'auth' => [
            'user' => auth()->user(),
        ],
    ]);
})->name('welcome');

Route::get('/login', function () {
    return Inertia::render('Auth/Login');
})->name('login');
Route::post('/login', [AuthenticatedSessionController::class, 'store']);

Route::get('/Secretaria/dashboard', [DashboardController::class, 'secretaria'])->name('secretaria.dashboard');
Route::get('/Psicologos/dashboard', [DashboardController::class, 'psicologo'])->name('psicologo.dashboard');
Route::get('/Clientes/dashboard', [DashboardController::class, 'cliente'])->name('cliente.dashboard');

Route::get('/secretaria/psychologists', [DashboardController::class, 'getPsychologists'])->name('secretaria.psychologists');

Route::get('/Secretaria/CadastroUsuario', [UserController::class, 'create'])->name('users.create');
Route::post('/Secretaria/CadastroCliente', [UserController::class, 'storeClient'])->name('clients.store');
Route::post('/Secretaria/CadastroPsicologo', [UserController::class, 'storePsicologo'])->name('psicologos.store');
Route::post('/Secretaria/CadastroSecretaria', [UserController::class, 'storeSecretaria'])->name('secretarias.store');


Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');


Route::get('/Psicologos/{id}/editar', [SessaoController::class, 'edit'])->name('sessions.edit');
Route::patch('/Psicologos/{id}', [SessaoController::class, 'update'])->name('sessions.update');

Route::get('/Cliente/{id}/Notas-Medicas', [SessaoController::class, 'show'])->name('sessions.notes');

Route::get('/psicologos/documentos', function () {
    return Inertia::render('Psicologos/documentos');
})->name('psicologos.documentos');


Route::get('/secretaria/sessoes', [SessaoController::class, 'index'])->name('secretaria.sessoes'); // Atualizado para listar sessões
Route::post('/schedule/sessao', [SessaoController::class, 'store'])->name('schedule.sessao'); // Atualizado para agendar sessões
Route::post('/announce-arrival', [SessaoController::class, 'announceArrival'])->name('announce.arrival');
Route::post('/mark-appointment', [SessaoController::class, 'storeAppointment'])->name('mark.appointment');

Route::post('/finish-session', [SessaoController::class, 'finishSession'])->name('finish.session');
Route::get('/psychologist-appointments', [SessaoController::class, 'getAppointmentsForPsychologist'])->name('psychologist.appointments');

Route::get('/Atestados/', [SessaoController::class, 'abrirAtestado'])->name('atestado');
Route::get('/Atestados/{id}', [SessaoController::class, 'atestados']); // Corrigir o nome do controlador

Route::post('/welcome', [testeController::class, 'storeSecretaria'])->name('secretarias.teste');

Route::delete('/sessions/{id}', [SessaoController::class, 'cancelSession']);

require __DIR__.'/auth.php';

<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('permissions')->get();

        return view('index', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
                'nome' => 'required|string|max:100',
                'telefone' => 'required',
                'nivel' => 'required',
            ],[
                'nome.required' => 'O campo nome é obrigatório.',
                'nome.max' => 'O nome não deve ter mais de 255 caracteres.',
                'telefone.required' => 'O campo telefone é obrigatório.',
                'nivel.required' => 'O campo nível permissão é obrigatório.',
            ],
        );

        try {
            $telefone = $request->input('telefone');
            $clearTelefone = preg_replace('/[^0-9]/', '', $telefone);

            $usuario = new User();
            $usuario->preencherDados($request->nome, $clearTelefone, $request->nivel);
            $usuario->cadastrar();

            return redirect()->route('users.index')->with('success', 'Usuário cadastrado com sucesso!');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }
}

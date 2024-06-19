@extends('layouts.app')

@section('content')
    <h1>Tela de Usuário</h1>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
        <button class="btn btn-primary" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight"
            aria-controls="offcanvasRight">
            Novo Usuário
        </button>
    </div>

    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="offcanvasRightLabel">Cadastro de usuário</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body position-relative">
            <form id="userForm" class="row g-3" method="POST" action="{{ route('cadastrar') }}">
                @csrf
                <div class="col-md-6">
                    <label for="nome" class="form-label">Nome</label>
                    <input type="text" class="form-control @error('nome') is-invalid @enderror" id="nome"
                        name="nome" value="{{ old('nome') }}" placeholder="Digite seu Nome">
                    @error('nome')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label for="telefone" class="form-label">Telefone</label>
                    <input type="text" class="form-control @error('telefone') is-invalid @enderror" id="telefone"
                        name="telefone" value="{{ old('telefone') }}" placeholder="Digite seu Telefone">
                    @error('telefone')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-6">
                    <label for="nivel" class="form-label">Nível de Permissão</label>
                    <input type="number" class="form-control @error('nivel') is-invalid @enderror" id="nivel"
                        name="nivel" value="{{ old('nivel') }}">
                    @error('nivel')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-12">
                    <button id="submitForm" type="submit" class="btn btn-success px-5">Salvar</button>
                </div>
            </form>
        </div>
    </div>

    @if ($users->isEmpty())
        <p>Não há dados disponíveis.</p>
    @else
        <table class="table table-hover">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Nome</th>
                    <th scope="col">Telefone</th>
                    <th scope="col">Nível de Permissão</th>
                    <th scope="col">Data de Cadastro</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->nome }}</td>
                        <td>{{ $user->formatTelefone() }}</td>
                        <td>{{ $user->permissions->nivel }}</td>
                        <td>{{ $user->created_at->format('d/m/Y') }} as {{ $user->created_at->format('H:i') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

@endsection

@section('script')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('userForm').addEventListener('submit', function(event) {
                event.preventDefault();
                document.querySelectorAll('.form-control').forEach(function(el) {
                    el.classList.remove('is-invalid');
                });
                document.querySelectorAll('.invalid-feedback').forEach(function(el) {
                    el.remove();
                });

                var nome = document.getElementById('nome').value.trim();
                var telefone = document.getElementById('telefone').value.trim();
                var nivel = document.getElementById('nivel').value.trim();

                var errors = [];

                if (nome === '') {
                    errors.push('O campo nome é obrigatório.');
                    document.getElementById('nome').classList.add('is-invalid');
                }

                if (telefone === '') {
                    errors.push('O campo telefone é obrigatório.');
                    document.getElementById('telefone').classList.add('is-invalid');
                }

                if (nivel === '') {
                    errors.push('O campo nível permissão é obrigatório.');
                    document.getElementById('nivel').classList.add('is-invalid');
                } else if (isNaN(nivel)) {
                    errors.push('O campo nível permissão deve ser um número.');
                    document.getElementById('nivel').classList.add('is-invalid');
                }

                if (errors.length > 0) {
                    errors.forEach(function(error) {
                        var errorDiv = document.createElement('div');
                        errorDiv.classList.add('invalid-feedback');
                        errorDiv.textContent = error;

                        if (error.includes('nome')) {
                            document.getElementById('nome').classList.add('is-invalid');
                            document.getElementById('nome').parentNode.appendChild(errorDiv);
                        } else if (error.includes('telefone')) {
                            document.getElementById('telefone').classList.add('is-invalid');
                            document.getElementById('telefone').parentNode.appendChild(errorDiv);
                        } else if (error.includes('nível')) {
                            document.getElementById('nivel').classList.add('is-invalid');
                            document.getElementById('nivel').parentNode.appendChild(errorDiv);
                        }
                    });
                } else {
                    this.submit();
                }
            });
        });

        $(document).ready(function($) {
            $('#telefone').mask('(99) 9 9999-9999');
        });
    </script>
@endsection

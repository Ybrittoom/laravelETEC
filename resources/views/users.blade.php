@extends('layout')

@section('title', 'Usuários')

@section('content')

<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Gerenciamento de Usuários</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ url('/dashboard') }}">Início</a></li>
                    <li class="breadcrumb-item active">Usuários</li>
                </ol>
            </div>
        </div>
    </div>
</section>

<section class="content">
    <div class="container-fluid">

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                <i class="icon fas fa-check"></i> {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert">&times;</button>
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show">
                <i class="icon fas fa-ban"></i> {{ session('error') }}
                <button type="button" class="close" data-dismiss="alert">&times;</button>
            </div>
        @endif

        <div class="card">
            <div class="card-header d-flex align-items-center">
                <h3 class="card-title mr-3">Lista de Usuários</h3>
                <a href="{{ route('users.create') }}" class="btn btn-sm btn-success">
                    <i class="fas fa-plus"></i> Novo Registro
                </a>
                <div class="card-tools ml-auto">
                    <form action="{{ route('users') }}" method="GET">
                        <div class="input-group input-group-sm" style="width: 250px;">
                            <input type="text" name="search" class="form-control"
                                   placeholder="Pesquisar..." value="{{ $search ?? '' }}">
                            <div class="input-group-append">
                                <button type="submit" class="btn btn-default">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nome</th>
                            <th>E-mail</th>
                            <th>Ativo</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $user)
                        <tr>
                            <td>{{ $user->id }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                                @if($user->active)
                                    <span class="badge badge-success">Sim</span>
                                @else
                                    <span class="badge badge-secondary">Não</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('users.edit', $user->id) }}"
                                   class="btn btn-sm btn-info" title="Editar">
                                    <i class="fas fa-edit"></i>
                                </a>

                                {{-- ✅ Botão abre modal bonito (não o confirm feio do browser) --}}
                                <button type="button"
                                        class="btn btn-sm btn-danger btn-delete"
                                        title="Excluir"
                                        data-id="{{ $user->id }}"
                                        data-name="{{ $user->name }}"
                                        data-action="{{ route('users.destroy', $user->id) }}">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted py-3">
                                <i class="fas fa-users mr-1"></i> Nenhum usuário encontrado.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="card-footer clearfix">
                {{ $users->appends(['search' => $search])->links() }}
            </div>
        </div>
    </div>
</section>

{{-- ✅ Modal de confirmação de exclusão --}}
<div class="modal fade" id="modalDelete" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width: 420px;">
        <div class="modal-content" style="border-radius: 12px; overflow: hidden; border: none; box-shadow: 0 20px 60px rgba(0,0,0,0.3);">

            {{-- Cabeçalho vermelho --}}
            <div style="background: linear-gradient(135deg, #e53935, #c62828); padding: 28px 24px 20px; text-align: center;">
                <div style="width: 64px; height: 64px; background: rgba(255,255,255,0.2); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 12px;">
                    <i class="fas fa-trash-alt" style="font-size: 28px; color: #fff;"></i>
                </div>
                <h4 style="color: #fff; margin: 0; font-weight: 700; font-size: 20px;">Excluir Usuário</h4>
            </div>

            {{-- Corpo --}}
            <div class="modal-body" style="padding: 24px; text-align: center; background: #fff;">
                <p style="color: #555; font-size: 15px; margin-bottom: 4px;">Você está prestes a excluir:</p>
                <p id="modal-user-name" style="font-size: 18px; font-weight: 700; color: #212121; margin-bottom: 8px;"></p>
                <p style="color: #888; font-size: 13px;">
                    <i class="fas fa-exclamation-triangle text-warning mr-1"></i>
                    Esta ação também apagará todas as mensagens do chat deste usuário e <strong>não pode ser desfeita</strong>.
                </p>
            </div>

            {{-- Botões --}}
            <div style="padding: 0 24px 24px; background: #fff; display: flex; gap: 10px;">
                <button type="button" class="btn btn-default btn-block"
                        data-dismiss="modal"
                        style="flex: 1; border-radius: 8px; font-weight: 600;">
                    <i class="fas fa-times mr-1"></i> Cancelar
                </button>

                <form id="form-delete" method="POST" style="flex: 1; margin: 0;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-block"
                            style="border-radius: 8px; font-weight: 600;">
                        <i class="fas fa-trash mr-1"></i> Sim, excluir
                    </button>
                </form>
            </div>

        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    // Quando clicar em qualquer botão .btn-delete, preenche e abre o modal
    $(document).on('click', '.btn-delete', function () {
        var name   = $(this).data('name');
        var action = $(this).data('action');

        $('#modal-user-name').text(name);
        $('#form-delete').attr('action', action);
        $('#modalDelete').modal('show');
    });
</script>
@endpush
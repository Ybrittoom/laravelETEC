@extends('layout')
@section('title', 'Produtos')

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1><i class="fas fa-bicycle mr-2"></i>Produtos — Estoque</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Início</a></li>
                    <li class="breadcrumb-item active">Produtos</li>
                </ol>
            </div>
        </div>
    </div>
</section>

<section class="content">
<div class="container-fluid">

    {{-- Alertas --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <i class="icon fas fa-check"></i> {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <i class="icon fas fa-ban"></i> {{ session('error') }}
        </div>
    @endif

    {{-- Cards de resumo --}}
    <div class="row mb-3">
        <div class="col-md-4">
            <div class="info-box shadow-sm">
                <span class="info-box-icon bg-info"><i class="fas fa-bicycle"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Total de Produtos</span>
                    <span class="info-box-number">{{ $totalBikes }}</span>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="info-box shadow-sm">
                <span class="info-box-icon {{ $lowStock > 0 ? 'bg-warning' : 'bg-success' }}">
                    <i class="fas fa-exclamation-triangle"></i>
                </span>
                <div class="info-box-content">
                    <span class="info-box-text">Estoque Baixo / Zerado</span>
                    <span class="info-box-number">{{ $lowStock }}</span>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="info-box shadow-sm">
                <span class="info-box-icon bg-success"><i class="fas fa-dollar-sign"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Valor em Estoque</span>
                    <span class="info-box-number">R$ {{ number_format($totalValue, 2, ',', '.') }}</span>
                </div>
            </div>
        </div>
    </div>

    {{-- Filtros + botão novo --}}
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title"><i class="fas fa-filter mr-1"></i> Filtros</h3>
            <div class="card-tools">
                <a href="{{ route('bikes.create') }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-plus"></i> Novo Produto
                </a>
            </div>
        </div>
        <div class="card-body pb-1">
            <form action="{{ route('bikes.index') }}" method="GET">
                <div class="row">
                    <div class="col-md-5">
                        <div class="input-group input-group-sm mb-2">
                            <input type="text" name="search" class="form-control"
                                   placeholder="Nome, marca ou SKU..."
                                   value="{{ $search ?? '' }}">
                            <div class="input-group-append">
                                <button class="btn btn-default" type="submit">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <select name="category" class="form-control form-control-sm mb-2" onchange="this.form.submit()">
                            <option value="">Todas as categorias</option>
                            @foreach($categories as $key => $label)
                                <option value="{{ $key }}" {{ ($category ?? '') == $key ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <select name="status" class="form-control form-control-sm mb-2" onchange="this.form.submit()">
                            <option value="">Todos os status</option>
                            <option value="active"   {{ ($status ?? '') == 'active'   ? 'selected' : '' }}>Ativo</option>
                            <option value="inactive" {{ ($status ?? '') == 'inactive' ? 'selected' : '' }}>Inativo</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <a href="{{ route('bikes.index') }}" class="btn btn-default btn-sm btn-block mb-2">
                            <i class="fas fa-times"></i> Limpar
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- Grid de produtos --}}
    @if($bikes->isEmpty())
        <div class="text-center py-5 text-muted">
            <i class="fas fa-bicycle fa-4x mb-3 d-block"></i>
            <h4>Nenhum produto encontrado.</h4>
            <a href="{{ route('bikes.create') }}" class="btn btn-primary mt-2">
                <i class="fas fa-plus"></i> Cadastrar primeiro produto
            </a>
        </div>
    @else
    <div class="row">
        @foreach($bikes as $bike)
        <div class="col-xl-3 col-lg-4 col-md-6 mb-4">
            <div class="card h-100 shadow-sm" style="border-radius:12px; overflow:hidden; border:none;
                 {{ $bike->low_stock ? 'border-left: 4px solid #ffc107 !important;' : '' }}">

                {{-- Imagem --}}
                <div style="height:160px; background:#f0f2f5; overflow:hidden; position:relative;">
                    @if($bike->image)
                        <img src="{{ asset('storage/' . $bike->image) }}"
                             style="width:100%;height:100%;object-fit:cover;">
                    @else
                        <div class="d-flex align-items-center justify-content-center h-100">
                            <i class="fas fa-bicycle text-secondary" style="font-size:60px;opacity:0.3;"></i>
                        </div>
                    @endif

                    {{-- Badge categoria --}}
                    <span class="badge badge-primary"
                          style="position:absolute;top:8px;left:8px;font-size:10px;">
                        {{ $bike->category_label }}
                    </span>

                    {{-- Badge status --}}
                    @if($bike->status === 'inactive')
                    <span class="badge badge-secondary"
                          style="position:absolute;top:8px;right:8px;font-size:10px;">
                        Inativo
                    </span>
                    @endif

                    {{-- Alerta estoque baixo --}}
                    @if($bike->low_stock)
                    <span class="badge badge-warning"
                          style="position:absolute;bottom:8px;right:8px;font-size:10px;">
                        <i class="fas fa-exclamation-triangle"></i> Estoque baixo
                    </span>
                    @endif
                </div>

                <div class="card-body p-3">
                    <h6 class="font-weight-bold mb-0" style="line-height:1.3;">{{ $bike->name }}</h6>
                    <small class="text-muted">{{ $bike->brand }}{{ $bike->model ? ' · ' . $bike->model : '' }}</small>

                    @if($bike->sku)
                        <div class="mt-1"><small class="text-muted">SKU: <code>{{ $bike->sku }}</code></small></div>
                    @endif

                    {{-- Preço --}}
                    <div class="mt-2 d-flex align-items-baseline justify-content-between">
                        <span style="font-size:20px; font-weight:700; color:#1a73e8;">
                            R$ {{ number_format($bike->sale_price, 2, ',', '.') }}
                        </span>
                        @if($bike->margin > 0)
                        <span class="badge badge-success" title="Margem de lucro">
                            +{{ $bike->margin }}%
                        </span>
                        @endif
                    </div>
                    <small class="text-muted">Custo: R$ {{ number_format($bike->cost_price, 2, ',', '.') }}</small>

                    {{-- Estoque --}}
                    <div class="mt-2 d-flex align-items-center justify-content-between">
                        <span class="badge badge-{{ $bike->stock == 0 ? 'danger' : ($bike->low_stock ? 'warning' : 'success') }}"
                              style="font-size:12px;">
                            <i class="fas fa-boxes mr-1"></i>
                            {{ $bike->stock }} em estoque
                        </span>
                        <small class="text-muted">Mín: {{ $bike->stock_min }}</small>
                    </div>
                </div>

                {{-- Ações --}}
                <div class="card-footer p-2" style="background:#fafafa; border-top:1px solid #f0f0f0;">
                    <div class="d-flex gap-1" style="gap:6px;">
                        <a href="{{ route('bikes.show', $bike->id) }}"
                           class="btn btn-sm btn-outline-info flex-fill" title="Ver detalhes">
                            <i class="fas fa-eye"></i>
                        </a>
                        <a href="{{ route('bikes.edit', $bike->id) }}"
                           class="btn btn-sm btn-outline-warning flex-fill" title="Editar">
                            <i class="fas fa-edit"></i>
                        </a>
                        <button type="button"
                                class="btn btn-sm btn-outline-danger flex-fill btn-delete"
                                title="Excluir"
                                data-name="{{ $bike->name }}"
                                data-action="{{ route('bikes.destroy', $bike->id) }}">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    {{-- Paginação --}}
    <div class="d-flex justify-content-center">
        {{ $bikes->appends(request()->query())->links() }}
    </div>
    @endif

</div>
</section>

{{-- Modal de confirmação de exclusão --}}
<div class="modal fade" id="modalDelete" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered" style="max-width:420px;">
        <div class="modal-content" style="border-radius:14px;overflow:hidden;border:none;box-shadow:0 20px 60px rgba(0,0,0,0.25);">
            <div style="background:linear-gradient(135deg,#e53935,#c62828);padding:28px 24px 20px;text-align:center;">
                <div style="width:64px;height:64px;background:rgba(255,255,255,0.2);border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 12px;">
                    <i class="fas fa-trash-alt" style="font-size:28px;color:#fff;"></i>
                </div>
                <h4 style="color:#fff;margin:0;font-weight:700;">Excluir Produto</h4>
            </div>
            <div class="modal-body text-center" style="padding:24px;">
                <p style="color:#555;margin-bottom:4px;">Você está prestes a excluir:</p>
                <p id="modal-bike-name" style="font-size:18px;font-weight:700;color:#212121;"></p>
                <p style="color:#888;font-size:13px;">
                    <i class="fas fa-exclamation-triangle text-warning mr-1"></i>
                    Esta ação não pode ser desfeita.
                </p>
            </div>
            <div style="padding:0 24px 24px;display:flex;gap:10px;">
                <button type="button" class="btn btn-default btn-block" data-dismiss="modal"
                        style="flex:1;border-radius:8px;font-weight:600;">
                    <i class="fas fa-times mr-1"></i> Cancelar
                </button>
                <form id="form-delete" method="POST" style="flex:1;margin:0;">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-block"
                            style="border-radius:8px;font-weight:600;">
                        <i class="fas fa-trash mr-1"></i> Excluir
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
$(document).on('click', '.btn-delete', function() {
    $('#modal-bike-name').text($(this).data('name'));
    $('#form-delete').attr('action', $(this).data('action'));
    $('#modalDelete').modal('show');
});
</script>
@endpush
@extends('layout')
@section('title', $bike->name)

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6"><h1><i class="fas fa-bicycle mr-2"></i>{{ $bike->name }}</h1></div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Início</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('bikes.index') }}">Produtos</a></li>
                    <li class="breadcrumb-item active">Detalhes</li>
                </ol>
            </div>
        </div>
    </div>
</section>

<section class="content">
<div class="container-fluid">
<div class="row">

    {{-- Imagem + Ações --}}
    <div class="col-md-4">
        <div class="card shadow-sm" style="border-radius:12px;overflow:hidden;border:none;">
            @if($bike->image)
                <img src="{{ asset('storage/' . $bike->image) }}"
                     style="width:100%;max-height:280px;object-fit:cover;">
            @else
                <div style="height:220px;background:#f0f2f5;display:flex;align-items:center;justify-content:center;">
                    <i class="fas fa-bicycle text-secondary" style="font-size:80px;opacity:0.25;"></i>
                </div>
            @endif
            <div class="card-body">
                <span class="badge badge-primary mb-1">{{ $bike->category_label }}</span>
                <span class="badge badge-{{ $bike->status === 'active' ? 'success' : 'secondary' }} mb-1">
                    {{ $bike->status === 'active' ? 'Ativo' : 'Inativo' }}
                </span>
                @if($bike->sku)
                    <p class="text-muted mb-0 mt-1"><small>SKU: <code>{{ $bike->sku }}</code></small></p>
                @endif
            </div>
            <div class="card-footer" style="display:flex;gap:8px;">
                <a href="{{ route('bikes.edit', $bike->id) }}" class="btn btn-warning flex-fill">
                    <i class="fas fa-edit mr-1"></i> Editar
                </a>
                <button type="button" class="btn btn-danger flex-fill btn-delete"
                        data-name="{{ $bike->name }}"
                        data-action="{{ route('bikes.destroy', $bike->id) }}">
                    <i class="fas fa-trash mr-1"></i> Excluir
                </button>
            </div>
        </div>
    </div>

    {{-- Detalhes --}}
    <div class="col-md-8">

        {{-- Preços --}}
        <div class="row mb-3">
            <div class="col-sm-4">
                <div class="small-box bg-primary mb-0">
                    <div class="inner">
                        <h3>R$ {{ number_format($bike->sale_price, 2, ',', '.') }}</h3>
                        <p>Preço de Venda</p>
                    </div>
                    <div class="icon"><i class="fas fa-tag"></i></div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="small-box bg-secondary mb-0">
                    <div class="inner">
                        <h3>R$ {{ number_format($bike->cost_price, 2, ',', '.') }}</h3>
                        <p>Preço de Custo</p>
                    </div>
                    <div class="icon"><i class="fas fa-receipt"></i></div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="small-box {{ $bike->margin >= 0 ? 'bg-success' : 'bg-danger' }} mb-0">
                    <div class="inner">
                        <h3>{{ $bike->margin }}%</h3>
                        <p>Margem de Lucro</p>
                    </div>
                    <div class="icon"><i class="fas fa-chart-line"></i></div>
                </div>
            </div>
        </div>

        {{-- Estoque --}}
        <div class="card card-{{ $bike->stock == 0 ? 'danger' : ($bike->low_stock ? 'warning' : 'success') }} card-outline mb-3">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-boxes mr-1"></i> Estoque</h3>
            </div>
            <div class="card-body">
                <div class="row text-center">
                    <div class="col-4">
                        <div style="font-size:36px;font-weight:700;color:{{ $bike->stock == 0 ? '#dc3545' : ($bike->low_stock ? '#ffc107' : '#28a745') }};">
                            {{ $bike->stock }}
                        </div>
                        <small class="text-muted">Em estoque</small>
                    </div>
                    <div class="col-4">
                        <div style="font-size:36px;font-weight:700;color:#6c757d;">{{ $bike->stock_min }}</div>
                        <small class="text-muted">Estoque mínimo</small>
                    </div>
                    <div class="col-4">
                        <div style="font-size:36px;font-weight:700;color:#1a73e8;">
                            R$ {{ number_format($bike->sale_price * $bike->stock, 2, ',', '.') }}
                        </div>
                        <small class="text-muted">Valor em estoque</small>
                    </div>
                </div>
                @if($bike->low_stock)
                <div class="alert alert-{{ $bike->stock == 0 ? 'danger' : 'warning' }} mb-0 mt-3">
                    <i class="fas fa-exclamation-triangle mr-1"></i>
                    {{ $bike->stock == 0 ? 'Produto sem estoque!' : 'Estoque abaixo do mínimo! Considere reabastecer.' }}
                </div>
                @endif
            </div>
        </div>

        {{-- Descrição --}}
        @if($bike->description)
        <div class="card">
            <div class="card-header"><h3 class="card-title"><i class="fas fa-align-left mr-1"></i> Descrição</h3></div>
            <div class="card-body">
                <p style="white-space:pre-line;line-height:1.7;">{{ $bike->description }}</p>
            </div>
        </div>
        @endif

        {{-- Info adicional --}}
        <div class="card">
            <div class="card-header"><h3 class="card-title"><i class="fas fa-info-circle mr-1"></i> Informações</h3></div>
            <div class="card-body p-0">
                <table class="table table-sm mb-0">
                    <tr><th style="width:35%">Marca</th><td>{{ $bike->brand }}</td></tr>
                    @if($bike->model)<tr><th>Modelo</th><td>{{ $bike->model }}</td></tr>@endif
                    <tr><th>Categoria</th><td>{{ $bike->category_label }}</td></tr>
                    @if($bike->sku)<tr><th>SKU</th><td><code>{{ $bike->sku }}</code></td></tr>@endif
                    <tr><th>Cadastrado em</th><td>{{ $bike->created_at->format('d/m/Y H:i') }}</td></tr>
                    <tr><th>Última atualização</th><td>{{ $bike->updated_at->format('d/m/Y H:i') }}</td></tr>
                </table>
            </div>
        </div>

    </div>
</div>
</div>
</section>

{{-- Modal delete --}}
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
                <p style="color:#555;">Excluir <strong id="modal-bike-name"></strong>?</p>
                <p style="color:#888;font-size:13px;"><i class="fas fa-exclamation-triangle text-warning mr-1"></i>Esta ação não pode ser desfeita.</p>
            </div>
            <div style="padding:0 24px 24px;display:flex;gap:10px;">
                <button type="button" class="btn btn-default btn-block" data-dismiss="modal" style="flex:1;border-radius:8px;">Cancelar</button>
                <form id="form-delete" method="POST" style="flex:1;margin:0;">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-block" style="border-radius:8px;">
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
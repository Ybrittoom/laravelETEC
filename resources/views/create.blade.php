@extends('layout')
@section('title', 'Novo Produto')

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6"><h1><i class="fas fa-plus-circle mr-2"></i>Novo Produto</h1></div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Início</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('bikes.index') }}">Produtos</a></li>
                    <li class="breadcrumb-item active">Novo</li>
                </ol>
            </div>
        </div>
    </div>
</section>

<section class="content">
<div class="container-fluid">
<form action="{{ route('bikes.store') }}" method="POST" enctype="multipart/form-data">
@csrf

    @if($errors->any())
    <div class="alert alert-danger alert-dismissible">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <h5><i class="icon fas fa-ban"></i> Corrija os erros:</h5>
        <ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
    </div>
    @endif

    <div class="row">

        {{-- Coluna esquerda --}}
        <div class="col-md-8">

            {{-- Identificação --}}
            <div class="card card-primary card-outline">
                <div class="card-header"><h3 class="card-title"><i class="fas fa-tag mr-1"></i> Identificação</h3></div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label>Nome do Produto <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                                   placeholder="Ex: Trek Marlin 5 2024"
                                   value="{{ old('name') }}" required>
                            @error('name')<span class="invalid-feedback">{{ $message }}</span>@enderror
                        </div>
                        <div class="col-md-3 form-group">
                            <label>Marca <span class="text-danger">*</span></label>
                            <input type="text" name="brand" class="form-control @error('brand') is-invalid @enderror"
                                   placeholder="Trek, Caloi..."
                                   value="{{ old('brand') }}" required>
                            @error('brand')<span class="invalid-feedback">{{ $message }}</span>@enderror
                        </div>
                        <div class="col-md-3 form-group">
                            <label>Modelo</label>
                            <input type="text" name="model" class="form-control"
                                   placeholder="Marlin 5"
                                   value="{{ old('model') }}">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 form-group">
                            <label>Categoria <span class="text-danger">*</span></label>
                            <select name="category" class="form-control @error('category') is-invalid @enderror" required>
                                <option value="">Selecione...</option>
                                @foreach($categories as $key => $label)
                                    <option value="{{ $key }}" {{ old('category') == $key ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category')<span class="invalid-feedback">{{ $message }}</span>@enderror
                        </div>
                        <div class="col-md-4 form-group">
                            <label>SKU / Código</label>
                            <input type="text" name="sku" class="form-control @error('sku') is-invalid @enderror"
                                   placeholder="Ex: TRK-MRL5-24"
                                   value="{{ old('sku') }}">
                            @error('sku')<span class="invalid-feedback">{{ $message }}</span>@enderror
                        </div>
                        <div class="col-md-4 form-group">
                            <label>Status</label>
                            <select name="status" class="form-control">
                                <option value="active"   {{ old('status','active') == 'active'   ? 'selected' : '' }}>Ativo</option>
                                <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inativo</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Descrição</label>
                        <textarea name="description" class="form-control" rows="4"
                                  placeholder="Descreva o produto: especificações, tamanho de quadro, componentes, diferenciais...">{{ old('description') }}</textarea>
                    </div>
                </div>
            </div>

            {{-- Preços --}}
            <div class="card card-success card-outline">
                <div class="card-header"><h3 class="card-title"><i class="fas fa-dollar-sign mr-1"></i> Preços</h3></div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 form-group">
                            <label>Preço de Custo (R$) <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <div class="input-group-prepend"><span class="input-group-text">R$</span></div>
                                <input type="number" name="cost_price" step="0.01" min="0"
                                       class="form-control @error('cost_price') is-invalid @enderror"
                                       placeholder="0,00" value="{{ old('cost_price', '0.00') }}" required
                                       id="cost_price" oninput="calcMargin()">
                                @error('cost_price')<span class="invalid-feedback">{{ $message }}</span>@enderror
                            </div>
                        </div>
                        <div class="col-md-4 form-group">
                            <label>Preço de Venda (R$) <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <div class="input-group-prepend"><span class="input-group-text">R$</span></div>
                                <input type="number" name="sale_price" step="0.01" min="0"
                                       class="form-control @error('sale_price') is-invalid @enderror"
                                       placeholder="0,00" value="{{ old('sale_price', '0.00') }}" required
                                       id="sale_price" oninput="calcMargin()">
                                @error('sale_price')<span class="invalid-feedback">{{ $message }}</span>@enderror
                            </div>
                        </div>
                        <div class="col-md-4 form-group">
                            <label>Margem de Lucro</label>
                            <div class="input-group">
                                <input type="text" id="margin_display" class="form-control" readonly
                                       placeholder="—" style="background:#f8f9fa; font-weight:700;">
                                <div class="input-group-append"><span class="input-group-text">%</span></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        {{-- Coluna direita --}}
        <div class="col-md-4">

            {{-- Imagem --}}
            <div class="card card-warning card-outline">
                <div class="card-header"><h3 class="card-title"><i class="fas fa-image mr-1"></i> Foto do Produto</h3></div>
                <div class="card-body text-center">
                    <div id="preview-box"
                         style="width:100%;height:180px;background:#f0f2f5;border-radius:8px;
                                display:flex;align-items:center;justify-content:center;
                                margin-bottom:12px;overflow:hidden;border:2px dashed #dee2e6;">
                        <i class="fas fa-image text-secondary" style="font-size:48px;opacity:0.4;" id="preview-icon"></i>
                        <img id="preview-img" src="" style="display:none;width:100%;height:100%;object-fit:cover;">
                    </div>
                    <label class="btn btn-outline-warning btn-sm btn-block">
                        <i class="fas fa-upload mr-1"></i> Escolher imagem
                        <input type="file" name="image" accept="image/*" style="display:none;"
                               onchange="previewImage(this)">
                    </label>
                    <small class="text-muted d-block mt-1">JPG, PNG ou WEBP — máx. 2MB</small>
                </div>
            </div>

            {{-- Estoque --}}
            <div class="card card-info card-outline">
                <div class="card-header"><h3 class="card-title"><i class="fas fa-boxes mr-1"></i> Estoque</h3></div>
                <div class="card-body">
                    <div class="form-group">
                        <label>Quantidade em Estoque <span class="text-danger">*</span></label>
                        <input type="number" name="stock" min="0"
                               class="form-control @error('stock') is-invalid @enderror"
                               value="{{ old('stock', 0) }}" required>
                        @error('stock')<span class="invalid-feedback">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group mb-0">
                        <label>Estoque Mínimo (alerta) <span class="text-danger">*</span></label>
                        <input type="number" name="stock_min" min="0"
                               class="form-control @error('stock_min') is-invalid @enderror"
                               value="{{ old('stock_min', 2) }}" required>
                        <small class="text-muted">Abaixo deste valor aparece alerta de estoque baixo.</small>
                        @error('stock_min')<span class="invalid-feedback">{{ $message }}</span>@enderror
                    </div>
                </div>
            </div>

        </div>
    </div>

    {{-- Botões --}}
    <div class="card">
        <div class="card-footer">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save mr-1"></i> Salvar Produto
            </button>
            <a href="{{ route('bikes.index') }}" class="btn btn-default ml-2">Cancelar</a>
        </div>
    </div>

</form>
</div>
</section>
@endsection

@push('scripts')
<script>
function previewImage(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            $('#preview-img').attr('src', e.target.result).show();
            $('#preview-icon').hide();
        };
        reader.readAsDataURL(input.files[0]);
    }
}

function calcMargin() {
    var cost = parseFloat($('#cost_price').val()) || 0;
    var sale = parseFloat($('#sale_price').val()) || 0;
    if (cost > 0 && sale > 0) {
        var margin = ((sale - cost) / cost * 100).toFixed(1);
        $('#margin_display').val(margin)
            .css('color', margin >= 0 ? '#28a745' : '#dc3545');
    } else {
        $('#margin_display').val('');
    }
}
</script>
@endpush
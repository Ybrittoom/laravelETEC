@extends('layout')
@section('title', 'Editar Produto')

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6"><h1><i class="fas fa-edit mr-2"></i>Editar Produto</h1></div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Início</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('bikes.index') }}">Produtos</a></li>
                    <li class="breadcrumb-item active">Editar</li>
                </ol>
            </div>
        </div>
    </div>
</section>

<section class="content">
<div class="container-fluid">
<form action="{{ route('bikes.update', $bike->id) }}" method="POST" enctype="multipart/form-data">
@csrf @method('PUT')

    @if($errors->any())
    <div class="alert alert-danger alert-dismissible">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <h5><i class="icon fas fa-ban"></i> Corrija os erros:</h5>
        <ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
    </div>
    @endif

    <div class="row">
        <div class="col-md-8">

            <div class="card card-warning card-outline">
                <div class="card-header"><h3 class="card-title">Editando: <strong>{{ $bike->name }}</strong></h3></div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label>Nome do Produto <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                                   value="{{ old('name', $bike->name) }}" required>
                            @error('name')<span class="invalid-feedback">{{ $message }}</span>@enderror
                        </div>
                        <div class="col-md-3 form-group">
                            <label>Marca <span class="text-danger">*</span></label>
                            <input type="text" name="brand" class="form-control @error('brand') is-invalid @enderror"
                                   value="{{ old('brand', $bike->brand) }}" required>
                            @error('brand')<span class="invalid-feedback">{{ $message }}</span>@enderror
                        </div>
                        <div class="col-md-3 form-group">
                            <label>Modelo</label>
                            <input type="text" name="model" class="form-control"
                                   value="{{ old('model', $bike->model) }}">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 form-group">
                            <label>Categoria <span class="text-danger">*</span></label>
                            <select name="category" class="form-control" required>
                                @foreach($categories as $key => $label)
                                    <option value="{{ $key }}" {{ old('category', $bike->category) == $key ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4 form-group">
                            <label>SKU / Código</label>
                            <input type="text" name="sku" class="form-control @error('sku') is-invalid @enderror"
                                   value="{{ old('sku', $bike->sku) }}">
                            @error('sku')<span class="invalid-feedback">{{ $message }}</span>@enderror
                        </div>
                        <div class="col-md-4 form-group">
                            <label>Status</label>
                            <select name="status" class="form-control">
                                <option value="active"   {{ old('status', $bike->status) == 'active'   ? 'selected' : '' }}>Ativo</option>
                                <option value="inactive" {{ old('status', $bike->status) == 'inactive' ? 'selected' : '' }}>Inativo</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Descrição</label>
                        <textarea name="description" class="form-control" rows="4">{{ old('description', $bike->description) }}</textarea>
                    </div>
                </div>
            </div>

            <div class="card card-success card-outline">
                <div class="card-header"><h3 class="card-title"><i class="fas fa-dollar-sign mr-1"></i> Preços</h3></div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 form-group">
                            <label>Preço de Custo (R$) <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <div class="input-group-prepend"><span class="input-group-text">R$</span></div>
                                <input type="number" name="cost_price" step="0.01" min="0"
                                       class="form-control" id="cost_price"
                                       value="{{ old('cost_price', $bike->cost_price) }}"
                                       required oninput="calcMargin()">
                            </div>
                        </div>
                        <div class="col-md-4 form-group">
                            <label>Preço de Venda (R$) <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <div class="input-group-prepend"><span class="input-group-text">R$</span></div>
                                <input type="number" name="sale_price" step="0.01" min="0"
                                       class="form-control" id="sale_price"
                                       value="{{ old('sale_price', $bike->sale_price) }}"
                                       required oninput="calcMargin()">
                            </div>
                        </div>
                        <div class="col-md-4 form-group">
                            <label>Margem de Lucro</label>
                            <div class="input-group">
                                <input type="text" id="margin_display" class="form-control" readonly
                                       style="background:#f8f9fa;font-weight:700;">
                                <div class="input-group-append"><span class="input-group-text">%</span></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">

            <div class="card card-warning card-outline">
                <div class="card-header"><h3 class="card-title"><i class="fas fa-image mr-1"></i> Foto</h3></div>
                <div class="card-body text-center">
                    <div id="preview-box"
                         style="width:100%;height:180px;background:#f0f2f5;border-radius:8px;
                                display:flex;align-items:center;justify-content:center;
                                margin-bottom:12px;overflow:hidden;border:2px dashed #dee2e6;">
                        @if($bike->image)
                            <img id="preview-img" src="{{ asset('storage/' . $bike->image) }}"
                                 style="width:100%;height:100%;object-fit:cover;">
                            <i class="fas fa-image text-secondary" style="font-size:48px;opacity:0.4;display:none;" id="preview-icon"></i>
                        @else
                            <i class="fas fa-image text-secondary" style="font-size:48px;opacity:0.4;" id="preview-icon"></i>
                            <img id="preview-img" src="" style="display:none;width:100%;height:100%;object-fit:cover;">
                        @endif
                    </div>
                    <label class="btn btn-outline-warning btn-sm btn-block">
                        <i class="fas fa-upload mr-1"></i> Trocar imagem
                        <input type="file" name="image" accept="image/*" style="display:none;"
                               onchange="previewImage(this)">
                    </label>
                    <small class="text-muted">Deixe em branco para manter a atual.</small>
                </div>
            </div>

            <div class="card card-info card-outline">
                <div class="card-header"><h3 class="card-title"><i class="fas fa-boxes mr-1"></i> Estoque</h3></div>
                <div class="card-body">
                    <div class="form-group">
                        <label>Quantidade em Estoque <span class="text-danger">*</span></label>
                        <input type="number" name="stock" min="0" class="form-control"
                               value="{{ old('stock', $bike->stock) }}" required>
                    </div>
                    <div class="form-group mb-0">
                        <label>Estoque Mínimo (alerta)</label>
                        <input type="number" name="stock_min" min="0" class="form-control"
                               value="{{ old('stock_min', $bike->stock_min) }}" required>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <div class="card">
        <div class="card-footer">
            <button type="submit" class="btn btn-warning">
                <i class="fas fa-save mr-1"></i> Salvar Alterações
            </button>
            <a href="{{ route('bikes.index') }}" class="btn btn-default ml-2">Cancelar</a>
            <a href="{{ route('bikes.show', $bike->id) }}" class="btn btn-info ml-2">
                <i class="fas fa-eye mr-1"></i> Ver detalhes
            </a>
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
    if (cost > 0) {
        var margin = ((sale - cost) / cost * 100).toFixed(1);
        $('#margin_display').val(margin).css('color', margin >= 0 ? '#28a745' : '#dc3545');
    }
}
$(document).ready(function() { calcMargin(); });
</script>
@endpush
@extends('layouts.admin')

@section('title', isset($product) ? 'Editar producto' : 'Nuevo producto')
@section('subtitle', isset($product) ? 'Modifica los datos del producto' : 'Registra un nuevo producto en el catálogo')

@section('content')
    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <form method="POST" enctype="multipart/form-data"
                  action="{{ isset($product) ? route('admin.products.update', $product) : route('admin.products.store') }}">
                @csrf
                @if (isset($product)) @method('PUT') @endif

                <div class="row g-3">
                    <div class="col-md-8">
                        <h6 class="fw-bold mb-3"><i class="bi bi-bag me-2 text-brand"></i>Información básica</h6>

                        <div class="row g-3">
                            <div class="col-12">
                                <label class="form-label">Nombre del producto <span class="text-danger">*</span></label>
                                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                                       value="{{ old('name', $product->name ?? '') }}" required>
                                @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Slug</label>
                                <input type="text" name="slug" class="form-control @error('slug') is-invalid @enderror"
                                       value="{{ old('slug', $product->slug ?? '') }}" placeholder="ej: laptop-gamer-pro">
                                <div class="form-text">Debe contener solo letras minúsculas, números y guiones.</div>
                                @error('slug')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Referencia (SKU)</label>
                                <input type="text" name="sku" class="form-control @error('sku') is-invalid @enderror"
                                       value="{{ old('sku', $product->sku ?? '') }}" placeholder="ej: LAP-001">
                                @error('sku')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-12">
                                <label class="form-label">Descripción</label>
                                <textarea name="description" rows="4" class="form-control @error('description') is-invalid @enderror" placeholder="Describe el producto, sus características...">{{ old('description', $product->description ?? '') }}</textarea>
                                @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <h6 class="fw-bold mb-3"><i class="bi bi-image me-2 text-brand"></i>Imagen del producto</h6>
                        <div class="text-center mb-3">
                            <img src="{{ isset($product) ? product_image($product) : 'https://placehold.co/600x400?text=Sin+imagen' }}"
                                 id="imagePreview" alt="Vista previa" style="width:100%; max-height:220px; object-fit:cover; border-radius:.75rem; background:#f1f5f9;">
                        </div>
                        <input type="file" name="image" id="imageInput" class="form-control @error('image') is-invalid @enderror"
                               accept="image/*">
                        @error('image')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        @if (isset($product) && $product->image)
                            <div class="form-check mt-2">
                                <input type="checkbox" name="remove_image" value="1" id="removeImage" class="form-check-input">
                                <label for="removeImage" class="form-check-label small text-danger">Eliminar imagen actual</label>
                            </div>
                        @endif
                    </div>

                    <div class="col-12">
                        <hr>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Categoría</label>
                        <select name="category_id" class="form-select @error('category_id') is-invalid @enderror">
                            <option value="">Sin categoría</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id', $product->category_id ?? '') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Precio de venta (Bs) <span class="text-danger">*</span></label>
                        <input type="number" step="0.01" min="0" name="price" class="form-control @error('price') is-invalid @enderror"
                               value="{{ old('price', $product->price ?? 0) }}" required>
                        @error('price')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Costo de adquisición (Bs)</label>
                        <input type="number" step="0.01" min="0" name="cost" class="form-control @error('cost') is-invalid @enderror"
                               value="{{ old('cost', $product->cost ?? 0) }}" required>
                        @error('cost')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Stock inicial <span class="text-danger">*</span></label>
                        <input type="number" min="0" name="stock" class="form-control @error('stock') is-invalid @enderror"
                               value="{{ old('stock', $product->stock ?? 0) }}" required>
                        @error('stock')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Estado del producto</label>
                        <select name="status" class="form-select">
                            <option value="available" {{ old('status', $product->status ?? 'available') === 'available' ? 'selected' : '' }}>Disponible / En venta</option>
                            <option value="out_of_stock" {{ old('status', $product->status ?? '') === 'out_of_stock' ? 'selected' : '' }}>Agotado</option>
                            <option value="defective" {{ old('status', $product->status ?? '') === 'defective' ? 'selected' : '' }}>Defectuoso / No vendible</option>
                        </select>
                    </div>
                    <div class="col-md-4 align-self-end">
                        <div class="form-check form-switch">
                            <input type="checkbox" name="is_featured" value="1" id="isFeatured" class="form-check-input"
                                   {{ old('is_featured', $product->is_featured ?? 0) ? 'checked' : '' }}>
                            <label for="isFeatured" class="form-check-label">Producto destacado en la página principal</label>
                        </div>
                    </div>

                    <div class="col-12 mt-4">
                        <button class="btn btn-brand px-4">
                            <i class="bi bi-check-lg me-2"></i>{{ isset($product) ? 'Guardar cambios' : 'Crear producto' }}
                        </button>
                        <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary px-4">Cancelar</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    document.getElementById('imageInput')?.addEventListener('change', function (e) {
        if (e.target.files && e.target.files[0]) {
            const reader = new FileReader();
            reader.onload = function (ev) {
                document.getElementById('imagePreview').src = ev.target.result;
            };
            reader.readAsDataURL(e.target.files[0]);
        }
    });
    document.getElementById('removeImage')?.addEventListener('change', function () {
        if (this.checked) {
            document.getElementById('imagePreview').src = 'https://placehold.co/600x400?text=Sin+imagen';
        }
    });
</script>
@endpush
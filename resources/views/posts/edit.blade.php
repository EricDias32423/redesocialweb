@extends('layouts.app')

@section('title', 'Editar Post')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-0 pt-4">
                <h4 class="mb-0 fw-bold">
                    <i class="fas fa-edit me-2" style="color: var(--primary-blue);"></i>
                    Editar Post
                </h4>
                <p class="text-muted small mb-0">Atualize as informações do seu post</p>
            </div>

            <div class="card-body pt-2">
                {{-- Mensagens de erro --}}
                @if($errors->any())
                    <div class="alert alert-danger border-0 bg-danger bg-opacity-10 text-danger py-2">
                        <i class="fas fa-exclamation-circle me-2"></i>
                        <strong>Por favor, corrija os seguintes erros:</strong>
                        <ul class="mb-0 mt-2 small">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('posts.update', $post) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label for="title" class="form-label text-muted small fw-semibold">TÍTULO DO POST</label>
                        <input type="text" 
                               class="form-control @error('title') is-invalid @enderror" 
                               id="title" 
                               name="title" 
                               value="{{ old('title', $post->title) }}"
                               required>
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="category" class="form-label text-muted small fw-semibold">CATEGORIA</label>
                        <select class="form-select @error('category') is-invalid @enderror" 
                                id="category" 
                                name="category">
                            <option value="">Selecione uma categoria (opcional)</option>
                            <option value="Educação" {{ (old('category', $post->category) == 'Educação') ? 'selected' : '' }}>Educação</option>
                            <option value="Saúde" {{ (old('category', $post->category) == 'Saúde') ? 'selected' : '' }}>Saúde</option>
                            <option value="Meio Ambiente" {{ (old('category', $post->category) == 'Meio Ambiente') ? 'selected' : '' }}>Meio Ambiente</option>
                            <option value="Direitos Humanos" {{ (old('category', $post->category) == 'Direitos Humanos') ? 'selected' : '' }}>Direitos Humanos</option>
                            <option value="Animais" {{ (old('category', $post->category) == 'Animais') ? 'selected' : '' }}>Animais</option>
                            <option value="Cultura" {{ (old('category', $post->category) == 'Cultura') ? 'selected' : '' }}>Cultura</option>
                        </select>
                        @error('category')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="content" class="form-label text-muted small fw-semibold">CONTEÚDO</label>
                        <textarea class="form-control @error('content') is-invalid @enderror" 
                                  id="content" 
                                  name="content" 
                                  rows="6"
                                  required>{{ old('content', $post->content) }}</textarea>
                        @error('content')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    @if($post->image)
                        <div class="mb-4">
                            <label class="form-label text-muted small fw-semibold">IMAGEM ATUAL</label>
                            <div class="border rounded p-3 bg-light">
                                <div class="d-flex align-items-center gap-3">
                                    <img src="{{ asset('storage/' . $post->image) }}" 
                                         class="rounded" 
                                         style="max-height: 80px;">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="remove_image" id="remove_image" value="1">
                                        <label class="form-check-label text-danger" for="remove_image">
                                            <i class="fas fa-trash-alt me-1"></i>Remover imagem atual
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    <div class="mb-4">
                        <label for="image" class="form-label text-muted small fw-semibold">NOVA IMAGEM</label>
                        <div class="border rounded p-3 bg-light">
                            <input type="file" 
                                   class="form-control @error('image') is-invalid @enderror" 
                                   id="image" 
                                   name="image" 
                                   accept="image/*">
                            <small class="text-muted d-block mt-2">Deixe em branco para manter a imagem atual</small>
                        </div>
                        @error('image')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div id="image-preview" class="mb-4 text-center" style="display: none;">
                        <div class="border rounded p-2">
                            <img src="#" alt="Preview" class="img-fluid rounded" style="max-height: 200px;">
                            <small class="text-muted d-block mt-1">Preview da nova imagem</small>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between pt-2">
                        <a href="{{ route('posts.show', $post) }}" class="btn btn-outline-secondary px-4">
                            <i class="fas fa-times me-2"></i>Cancelar
                        </a>
                        <button type="submit" class="btn btn-primary px-4">
                            <i class="fas fa-save me-2"></i>Atualizar Post
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.getElementById('image').addEventListener('change', function(e) {
    const preview = document.getElementById('image-preview');
    const img = preview.querySelector('img');
    const file = e.target.files[0];
    
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            img.src = e.target.result;
            preview.style.display = 'block';
        }
        reader.readAsDataURL(file);
    } else {
        preview.style.display = 'none';
    }
});
</script>
@endpush
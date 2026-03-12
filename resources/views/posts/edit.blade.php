@extends('layouts.app')

@section('title', 'Editar Post')

@section('content')
<div class="row">
    <div class="col-md-8 mx-auto">
        <div class="card">
            <div class="card-header bg-warning text-white">
                <h4 class="mb-0"><i class="fas fa-edit me-2"></i>Editar Post</h4>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('posts.update', $post) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="title" class="form-label">Título do Post</label>
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

                    <div class="mb-3">
                        <label for="category" class="form-label">Categoria</label>
                        <select class="form-select @error('category') is-invalid @enderror" 
                                id="category" 
                                name="category">
                            <option value="">Selecione uma categoria</option>
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

                    <div class="mb-3">
                        <label for="content" class="form-label">Conteúdo</label>
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
                        <div class="mb-3">
                            <label class="form-label">Imagem Atual</label>
                            <div>
                                <img src="{{ asset('storage/' . $post->image) }}" 
                                     class="img-fluid rounded mb-2" 
                                     style="max-height: 150px;">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remove_image" id="remove_image" value="1">
                                    <label class="form-check-label text-danger" for="remove_image">
                                        Remover imagem atual
                                    </label>
                                </div>
                            </div>
                        </div>
                    @endif

                    <div class="mb-3">
                        <label for="image" class="form-label">Nova Imagem (opcional)</label>
                        <input type="file" 
                               class="form-control @error('image') is-invalid @enderror" 
                               id="image" 
                               name="image" 
                               accept="image/*">
                        <small class="text-muted">Deixe em branco para manter a imagem atual</small>
                        @error('image')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <div id="image-preview" class="mt-2" style="display: none;">
                            <img src="#" alt="Preview" class="img-fluid rounded" style="max-height: 200px;">
                        </div>
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-warning">
                            <i class="fas fa-save me-2"></i>Atualizar Post
                        </button>
                        <a href="{{ route('posts.show', $post) }}" class="btn btn-outline-secondary">
                            <i class="fas fa-times me-2"></i>Cancelar
                        </a>
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
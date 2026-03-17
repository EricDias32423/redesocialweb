@extends('layouts.app')

@section('title', 'Criar Novo Post')

@section('content')
<div class="row">
    <div class="col-md-8 mx-auto">
        <div class="card shadow-lg border-0">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0"><i class="fas fa-plus-circle me-2"></i>Criar Novo Post</h4>
            </div>

            <div class="card-body">
                {{-- Mensagens de erro --}}
                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('posts.store') }}" enctype="multipart/form-data">
                    @csrf

                    {{-- Título --}}
                    <div class="mb-3">
                        <label for="title" class="form-label fw-bold">Título do Post</label>
                        <input type="text"
                               class="form-control @error('title') is-invalid @enderror"
                               id="title"
                               name="title"
                               value="{{ old('title') }}"
                               placeholder="Digite um título impactante"
                               required>
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Categoria --}}
                    <div class="mb-3">
                        <label for="category" class="form-label fw-bold">Categoria</label>
                        <select class="form-select @error('category') is-invalid @enderror"
                                id="category"
                                name="category">
                            <option value="" selected>Selecione uma categoria (opcional)</option>
                            <option value="Educação" {{ old('category') == 'Educação' ? 'selected' : '' }}>Educação</option>
                            <option value="Saúde" {{ old('category') == 'Saúde' ? 'selected' : '' }}>Saúde</option>
                            <option value="Meio Ambiente" {{ old('category') == 'Meio Ambiente' ? 'selected' : '' }}>Meio Ambiente</option>
                            <option value="Direitos Humanos" {{ old('category') == 'Direitos Humanos' ? 'selected' : '' }}>Direitos Humanos</option>
                            <option value="Animais" {{ old('category') == 'Animais' ? 'selected' : '' }}>Animais</option>
                            <option value="Cultura" {{ old('category') == 'Cultura' ? 'selected' : '' }}>Cultura</option>
                            <option value="Assistência Social" {{ old('category') == 'Assistência Social' ? 'selected' : '' }}>Assistência Social</option>
                        </select>
                        @error('category')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Conteúdo --}}
                    <div class="mb-3">
                        <label for="content" class="form-label fw-bold">Conteúdo</label>
                        <textarea class="form-control @error('content') is-invalid @enderror"
                                  id="content"
                                  name="content"
                                  rows="8"
                                  placeholder="Escreva aqui o conteúdo do seu post..."
                                  required>{{ old('content') }}</textarea>
                        @error('content')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Imagem --}}
                    <div class="mb-4">
                        <label for="image" class="form-label fw-bold">Imagem de destaque (opcional)</label>
                        <input type="file"
                               class="form-control @error('image') is-invalid @enderror"
                               id="image"
                               name="image"
                               accept="image/png, image/jpeg, image/jpg, image/gif">
                        <small class="text-muted">Formatos aceitos: JPG, JPEG, PNG, GIF. Máximo: 2MB</small>
                        @error('image')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror

                        {{-- Preview da imagem --}}
                        <div id="image-preview" class="mt-3 text-center" style="display: none;">
                            <img src="#" alt="Preview da imagem"
                                 class="img-fluid rounded border"
                                 style="max-height: 200px;">
                        </div>
                    </div>

                    {{-- Botões --}}
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('ong.dashboard') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-times me-2"></i>Cancelar
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-paper-plane me-2"></i>Publicar Post
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Preview da imagem antes do upload
    document.getElementById('image').addEventListener('change', function(e) {
        const preview = document.getElementById('image-preview');
        const img = preview.querySelector('img');
        const file = e.target.files[0];

        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                img.src = e.target.result;
                preview.style.display = 'block';
            };
            reader.readAsDataURL(file);
        } else {
            preview.style.display = 'none';
        }
    });

    // Validação simples de tamanho de imagem
    document.getElementById('image').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file && file.size > 2 * 1024 * 1024) {
            alert('A imagem não pode ter mais que 2MB.');
            this.value = '';
            document.getElementById('image-preview').style.display = 'none';
        }
    });
</script>
@endpush
@endsection
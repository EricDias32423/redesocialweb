@extends('layouts.app')

@section('title', 'Meus Posts')

@section('content')
<div class="row">
    <div class="col-md-8 mx-auto">
        <div class="card">
            <div class="card-header bg-success text-white d-flex justify-content-between align-items-center">
                <h4 class="mb-0"><i class="fas fa-user me-2"></i>Meus Posts</h4>
                <a href="{{ route('posts.create') }}" class="btn btn-light btn-sm">
                    <i class="fas fa-plus-circle me-1"></i>Novo Post
                </a>
            </div>
            <div class="card-body">
                @if($posts->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Título</th>
                                    <th>Categoria</th>
                                    <th>Data</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($posts as $post)
                                    <tr>
                                        <td>
                                            <a href="{{ route('posts.show', $post) }}">
                                                {{ Str::limit($post->title, 50) }}
                                            </a>
                                        </td>
                                        <td>
                                            @if($post->category)
                                                <span class="badge bg-info">{{ $post->category }}</span>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td>{{ $post->created_at->format('d/m/Y H:i') }}</td>
                                        <td>
                                            <a href="{{ route('posts.edit', $post) }}" class="btn btn-sm btn-warning">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('posts.destroy', $post) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Excluir este post?')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="d-flex justify-content-center mt-4">
                        {{ $posts->links() }}
                    </div>
                @else
                    <div class="text-center py-5">
                        <i class="fas fa-file-alt fa-4x text-muted mb-3"></i>
                        <h4 class="text-muted">Você ainda não tem posts</h4>
                        <a href="{{ route('posts.create') }}" class="btn btn-success mt-3">
                            <i class="fas fa-plus-circle me-2"></i>Criar primeiro post
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
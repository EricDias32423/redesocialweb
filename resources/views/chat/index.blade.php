@extends('layouts.app')

@section('title', 'Mensagens')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow-lg border-0">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">
                        <i class="fas fa-comments me-2"></i>Minhas Mensagens
                    </h4>
                </div>

                <div class="card-body p-0">
                    @if($conversations->isEmpty())
                        <div class="text-center py-5">
                            <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                            <p class="text-muted">Nenhuma conversa ainda</p>
                        </div>
                    @else
                        <div class="list-group list-group-flush">
                            @foreach($conversations as $conversation)
                                @php
                                    $other = $userType === 'regular' ? $conversation->ong : $conversation->regularUser;
                                    $otherName = $other->name ?? $other->ong_name ?? 'Contato';
                                    $lastMessage = $conversation->lastMessage();
                                    $unreadCount = $conversation->unreadCountFor($user->id, $userType);
                                @endphp

                                <a href="{{ route($routePrefix . '.chat.show', $conversation) }}" 
                                   class="list-group-item list-group-item-action border-0 border-bottom py-3 {{ $unreadCount > 0 ? 'bg-light' : '' }}">
                                    <div class="d-flex w-100 justify-content-between align-items-start">
                                        <div class="flex-grow-1">
                                            <h6 class="mb-1 fw-bold">
                                                {{ $otherName }}
                                                @if($unreadCount > 0)
                                                    <span class="badge bg-danger ms-2">{{ $unreadCount }}</span>
                                                @endif
                                            </h6>
                                            @if($lastMessage)
                                                <p class="mb-0 text-muted small">
                                                    <strong>{{ $lastMessage->senderName() }}:</strong>
                                                    {{ Str::limit($lastMessage->content, 50) }}
                                                </p>
                                            @else
                                                <p class="mb-0 text-muted small">Nenhuma mensagem ainda</p>
                                            @endif
                                        </div>
                                        <small class="text-muted">
                                            @if($lastMessage)
                                                {{ $lastMessage->created_at->diffForHumans() }}
                                            @endif
                                        </small>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@extends('layouts.app')

@section('title', 'Conversa com ' . $otherName)

@section('content')
<div class="container-fluid h-100">
    <div class="row h-100">
        <div class="col-md-3 border-end d-none d-md-block" style="max-height: calc(100vh - 100px); overflow-y: auto;">
            <div class="p-3">
                <h6 class="fw-bold mb-3">Minhas Conversas</h6>
                @php
                    $allConversations = $userType === 'regular'
                        ? \App\Models\Conversation::where('regular_user_id', $user->id)->with(['ong', 'messages'])->orderBy('last_message_at', 'desc')->get()
                        : \App\Models\Conversation::where('ong_id', $user->id)->with(['regularUser', 'messages'])->orderBy('last_message_at', 'desc')->get();
                @endphp

                <div class="list-group list-group-sm">
                    @foreach($allConversations as $conv)
                        @php
                            $convOther = $userType === 'regular' ? $conv->ong : $conv->regularUser;
                            $convOtherName = $convOther->name ?? $convOther->ong_name ?? 'Contato';
                        @endphp
                        <a href="{{ route($routePrefix . '.chat.show', $conv) }}"
                           class="list-group-item list-group-item-action {{ $conv->id === $conversation->id ? 'active' : '' }}">
                            <small class="fw-bold">{{ $convOtherName }}</small>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="col-md-9">
            <div class="d-flex flex-column h-100" style="max-height: calc(100vh - 100px);">
                <div class="border-bottom p-3 bg-light">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="mb-0">{{ $otherName }}</h5>
                            @if($userType === 'regular')
                                <small class="text-muted">ONG</small>
                            @else
                                <small class="text-muted">Usuario</small>
                            @endif
                        </div>
                        <a href="{{ route($routePrefix . '.chat.index') }}" class="btn btn-sm btn-outline-secondary d-md-none">
                            <i class="fas fa-arrow-left"></i>
                        </a>
                    </div>
                </div>

                <div class="flex-grow-1 p-3 overflow-auto" id="messages-container" style="background-color: #f8f9fa;">
                    @forelse($messages as $message)
                        @php
                            $isMine = $message->sender_id === $user->id && $message->sender_type === ($userType === 'regular' ? 'regular_user' : 'ong');
                        @endphp
                        <div class="mb-3 d-flex {{ $isMine ? 'justify-content-end' : 'justify-content-start' }}" data-message-id="{{ $message->id }}">
                            <div class="p-2 rounded {{ $isMine ? 'bg-primary text-white' : 'bg-white border' }}"
                                 style="max-width: 70%; word-wrap: break-word;">
                                @if(!$isMine)
                                    <small class="d-block fw-bold text-muted">{{ $message->senderName() }}</small>
                                @endif
                                <p class="mb-0">{{ $message->content }}</p>
                                <small class="d-block {{ $isMine ? 'text-white-50' : 'text-muted' }} text-end mt-1">
                                    {{ $message->created_at->format('H:i') }}
                                    @if($isMine && $message->read_at)
                                        <i class="fas fa-check-double ms-1"></i>
                                    @endif
                                </small>
                            </div>
                        </div>
                    @empty
                        <div class="text-center text-muted py-5">
                            <p>Nenhuma mensagem ainda. Comece a conversa!</p>
                        </div>
                    @endforelse
                </div>

                <div class="border-top p-3 bg-white">
                    <form id="message-form" method="POST" action="{{ route($routePrefix . '.chat.send', $conversation) }}">
                        @csrf
                        <div class="input-group">
                            <textarea class="form-control" id="content" name="content"
                                      placeholder="Digite sua mensagem..." rows="1"
                                      style="resize: none;" maxlength="5000"></textarea>
                            <button class="btn btn-primary" type="submit">
                                <i class="fas fa-paper-plane"></i>
                            </button>
                        </div>
                        @error('content')
                            <small class="text-danger d-block mt-2">{{ $message }}</small>
                        @enderror
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    const messagesUrl = @json(route($routePrefix . '.chat.api', $conversation));
    const sendMessageUrl = @json(route($routePrefix . '.chat.send', $conversation));
    const currentSenderType = @json($userType === 'regular' ? 'regular_user' : 'ong');
    const currentUserId = @json($user->id);
    let lastRenderedSignature = '';

    function scrollToBottom() {
        const container = document.getElementById('messages-container');
        container.scrollTop = container.scrollHeight;
    }

    function isNearBottom(container) {
        return container.scrollHeight - container.scrollTop - container.clientHeight < 80;
    }

    function createMessageElement(message) {
        const isMine = Number(message.sender_id) === Number(currentUserId) && message.sender_type === currentSenderType;
        const wrapper = document.createElement('div');
        wrapper.className = `mb-3 d-flex ${isMine ? 'justify-content-end' : 'justify-content-start'}`;
        wrapper.dataset.messageId = message.id;

        const bubble = document.createElement('div');
        bubble.className = `p-2 rounded ${isMine ? 'bg-primary text-white' : 'bg-white border'}`;
        bubble.style.maxWidth = '70%';
        bubble.style.wordWrap = 'break-word';

        if (!isMine) {
            const sender = document.createElement('small');
            sender.className = 'd-block fw-bold text-muted';
            sender.textContent = message.sender;
            bubble.appendChild(sender);
        }

        const content = document.createElement('p');
        content.className = 'mb-0';
        content.textContent = message.content;
        bubble.appendChild(content);

        const time = document.createElement('small');
        time.className = `d-block ${isMine ? 'text-white-50' : 'text-muted'} text-end mt-1`;
        time.textContent = message.created_at;

        if (isMine && message.read_at) {
            const check = document.createElement('i');
            check.className = 'fas fa-check-double ms-1';
            time.appendChild(check);
        }

        bubble.appendChild(time);
        wrapper.appendChild(bubble);

        return wrapper;
    }

    function renderMessages(messages) {
        const container = document.getElementById('messages-container');
        const nextSignature = JSON.stringify(messages.map(message => [message.id, message.read_at]));

        if (nextSignature === lastRenderedSignature) {
            return;
        }

        const previousMessageCount = container.querySelectorAll('[data-message-id]').length;
        const shouldScroll = isNearBottom(container) || messages.length > previousMessageCount;
        container.innerHTML = '';

        if (messages.length === 0) {
            const empty = document.createElement('div');
            empty.className = 'text-center text-muted py-5';
            empty.innerHTML = '<p>Nenhuma mensagem ainda. Comece a conversa!</p>';
            container.appendChild(empty);
        } else {
            messages.forEach(message => container.appendChild(createMessageElement(message)));
        }

        lastRenderedSignature = nextSignature;

        if (shouldScroll) {
            scrollToBottom();
        }
    }

    function refreshMessages() {
        fetch(messagesUrl, { headers: { 'Accept': 'application/json' } })
            .then(response => response.json())
            .then(data => renderMessages(data.messages || []))
            .catch(() => {});
    }

    scrollToBottom();
    refreshMessages();
    setInterval(refreshMessages, 2000);

    document.getElementById('message-form').addEventListener('submit', (e) => {
        e.preventDefault();

        const form = e.currentTarget;
        const content = document.getElementById('content');

        if (!content.value.trim()) {
            return;
        }

        fetch(sendMessageUrl, {
            method: 'POST',
            headers: {
                'Accept': 'application/json',
                'X-CSRF-TOKEN': form.querySelector('input[name="_token"]').value,
            },
            body: new FormData(form),
        })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Erro ao enviar mensagem');
                }

                content.value = '';
                refreshMessages();
            })
            .catch(() => form.submit());
    });

    document.getElementById('content').addEventListener('keydown', (e) => {
        if (e.ctrlKey && e.key === 'Enter') {
            document.getElementById('message-form').requestSubmit();
        }
    });
</script>
@endpush
@endsection

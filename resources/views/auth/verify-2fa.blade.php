@extends('layouts.app')

@section('title', 'Verificar Código')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6 col-lg-5">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white text-center py-4 border-0">
                <div class="mb-3">
                    <div class="rounded-circle bg-light d-inline-flex p-3">
                        <i class="fas fa-shield-alt fa-3x" style="color: var(--primary-blue);"></i>
                    </div>
                </div>
                <h4 class="mb-1 fw-bold">Verificação em duas etapas</h4>
                <p class="text-muted small">Digite o código enviado para seu e-mail</p>
            </div>

            <div class="card-body px-4 py-3">
                @if(session('success'))
                    <div class="alert alert-success border-0 bg-success bg-opacity-10 text-success py-2 mb-3">
                        <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                    </div>
                @endif

                @if(session('info'))
                    <div class="alert alert-info border-0 bg-info bg-opacity-10 text-info py-2 mb-3">
                        <i class="fas fa-info-circle me-2"></i>{{ session('info') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger border-0 bg-danger bg-opacity-10 text-danger py-2 mb-3">
                        <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('2fa.verify.submit') }}">
                    @csrf
                    <input type="hidden" name="user_id" value="{{ $user_id }}">
                    <input type="hidden" name="user_type" value="{{ $user_type ?? 'regular' }}">

                    <div class="mb-4">
                        <label for="code" class="form-label text-muted small fw-semibold">CÓDIGO DE VERIFICAÇÃO</label>
                        <div class="text-center">
                            <input type="text" 
                                   class="form-control text-center @error('code') is-invalid @enderror" 
                                   id="code" 
                                   name="code" 
                                   placeholder="000000"
                                   maxlength="6"
                                   style="font-size: 2rem; letter-spacing: 0.5rem;"
                                   required>
                            @error('code')
                                <div class="invalid-feedback text-center">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="text-center mt-3">
                            <small class="text-muted">
                                O código é válido por <strong>2 minutos</strong>.
                            </small>
                        </div>
                    </div>

                    <div class="d-grid mb-3">
                        <button type="submit" class="btn btn-primary py-2">
                            <i class="fas fa-check-circle me-2"></i>Verificar
                        </button>
                    </div>
                </form>

                <div class="text-center">
                    <form method="POST" action="{{ route('2fa.resend') }}">
                        @csrf
                        <input type="hidden" name="user_id" value="{{ $user_id }}">
                        <input type="hidden" name="user_type" value="{{ $user_type ?? 'regular' }}">
                        <button type="submit" class="btn btn-link text-muted small">
                            <i class="fas fa-redo-alt me-1"></i>Reenviar código
                        </button>
                    </form>
                    <a href="{{ route($login_route ?? 'regular.login') }}" class="text-muted small text-decoration-none">
                        <i class="fas fa-arrow-left me-1"></i>Voltar para o login
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

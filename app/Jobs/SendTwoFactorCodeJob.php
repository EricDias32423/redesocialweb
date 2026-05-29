<?php

namespace App\Jobs;

use App\Mail\TwoFactorCodeMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendTwoFactorCodeJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $user;
    protected $code;

    public function __construct($user, $code)
    {
        $this->user = $user;
        $this->code = $code;
    }

    public function handle(): void
    {
        $name = $this->user->name ?? $this->user->ong_name ?? $this->user->responsible_name ?? 'usuario';

        Mail::to($this->user->email)->send(new TwoFactorCodeMail($this->code, $name));
    }
}

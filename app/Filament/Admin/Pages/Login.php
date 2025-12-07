<?php

namespace App\Filament\Admin\Pages;

use Filament\Auth\Pages\Login as BaseLogin;                          // v4
use Filament\Auth\Http\Responses\Contracts\LoginResponse;            // v4 contract
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;                                         // v4 Schemas
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;


class Login extends BaseLogin
{
    protected int $maxAttempts = 3;
    protected int $decaySeconds = 120;

    // v4: gunakan Schema, bukan Form
    public function form(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('email')
                ->label('Email address')
                ->placeholder('you@example.com')
                ->email()
                ->required()
                ->autofocus()
                ->validationMessages([
                    'required' => 'Email wajib diisi.',
                    'email'    => 'Format email tidak valid.',
                ]),

            TextInput::make('password')
                ->label('Password')
                ->password()
                ->revealable()
                ->required()
                ->validationMessages([
                    'required' => 'Kata sandi wajib diisi.',
                ]),

            Checkbox::make('remember')
                ->label('Ingat saya'),
        ]);
    }

    // v4: kontrak LoginResponse baru
    public function authenticate(): ?LoginResponse
    {
        $this->enforceRateLimit();

        $response = parent::authenticate();

        // reset hit ketika berhasil login
        RateLimiter::clear($this->throttleKey());

        return $response;
    }

    protected function enforceRateLimit(): void
    {
        $key = $this->throttleKey();

        if (RateLimiter::tooManyAttempts($key, $this->maxAttempts)) {
            $seconds = RateLimiter::availableIn($key);

            throw ValidationException::withMessages([
                'data.email' => $this->rateLimitedMessage($seconds),
            ]);
        }

        RateLimiter::hit($key, $this->decaySeconds);
    }

    protected function throttleKey(): string
    {
        $email = (string) str($this->form->getState()['email'] ?? 'guest')->lower();
        $ip    = request()->ip();

        return 'filament_login:' . $email . '|' . $ip;
    }

    protected function rateLimitedMessage(int $seconds): string
    {
        return __('Terlalu banyak percobaan login. Coba lagi dalam :seconds detik.', [
            'seconds' => $seconds,
        ]);
    }

    protected function throwFailureValidationException(): never
    {
        throw ValidationException::withMessages([
            'data.email' => 'Email atau password salah.',
        ]);
    }
}

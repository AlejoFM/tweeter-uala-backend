<?php

namespace src\Tweet\App\FormRequests;

use Illuminate\Foundation\Http\FormRequest;

class CreateTweetFormRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'content' => 'required|string|max:280',
        ];
    }

    public function messages(): array
    {
        return [
            'content.required' => 'El contenido del tweet es requerido.',
            'content.string' => 'El contenido del tweet debe ser una cadena de caracteres.',
            'content.max' => 'El contenido del tweet debe tener menos de 280 caracteres.',
        ];
    }

    public function userId(): int
    {
        return (int) $this->header('X-User-Id');
    }

    public function content(): string
    {
        return $this->validated('content');
    }
}

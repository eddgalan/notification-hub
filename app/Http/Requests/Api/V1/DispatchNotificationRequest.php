<?php

namespace App\Http\Requests\Api\V1;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class DispatchNotificationRequest extends FormRequest
{
    /**
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return void
     */
    protected function prepareForValidation(): void
    {
        if (! $this->has('channels')) {
            $this->merge([
                'channels' => ['email', 'telegram'],
            ]);
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'channels' => ['required', 'array', 'min:1'],
            'channels.*' => ['required', 'string', 'in:email,telegram,sms'],
            'payload' => ['required', 'array'],
            'payload.user_id' => ['required', 'integer', 'exists:users,id'],
            'payload.email' => ['required', 'email', 'max:255'],
            'payload.message' => ['required', 'string', 'max:1000'],
        ];
    }
}

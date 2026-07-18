<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

final class ContactRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'name'    => ['required', 'string', 'min:2', 'max:120'],
            'email'   => ['required', 'email:rfc', 'max:190'],
            'message' => ['required', 'string', 'min:10', 'max:4000'],

            // Honeypot: a real visitor never sees this field, so anything in it
            // is a bot. Validated as "must be empty" rather than silently
            // dropped, which keeps the rejection visible in logs.
            'company' => ['nullable', 'prohibited'],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'name'    => __('contact.name'),
            'email'   => __('contact.email'),
            'message' => __('contact.message'),
        ];
    }

    public function withValidator(Validator $validator): void
    {
        $validator->after(function (Validator $validator): void {
            if (filled($this->input('company'))) {
                $validator->errors()->add('message', __('contact.rejected'));
            }
        });
    }
}

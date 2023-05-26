<?php

namespace App\Http\Requests;

use App\Exceptions\GeneralException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class StoreCandidateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:50',
            'source' => 'required|string|max:50',
            'owner' => 'required|exists:users,id'
        ];
    }

    /**
     * Handle a failed validation attempt.
     *
     * @param Validator $validator
     * @return void
     *
     * @throws GeneralException
     */
    protected function failedValidation(Validator $validator): void
    {
        throw new GeneralException($validator->errors(), 422);
    }
}

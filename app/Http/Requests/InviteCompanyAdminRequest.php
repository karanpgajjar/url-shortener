<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class InviteCompanyAdminRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()?->isSuperAdmin() ?? false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "company.name" => ["required", "string", "max:255"],
            "company.email" => ["required", "email", "max:255", "unique:companies,email"],
            "name" => ["required", "string", "max:255"],
            "email" => ["required", "email", "max:255", "unique:users,email"],
        ];
    }


    public function messages(): array
    {
        return [
            "company.email.unique" => "A company with this email already exists.",
            "email.unique" => "A user with this email already exists.",
        ];
    }
}

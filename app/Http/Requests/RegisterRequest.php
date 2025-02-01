<?php

namespace App\Http\Requests;
use App\Models\User;
use Illuminate\Validation\Rules;
use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'phone_no' => ['required', 'regex:/^(?:\+88|88)?01[3-9]\d{8}$/'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ];
    }
    public function messages()
    {
        return [
            'name.required' => 'The name field is required.',
            'name.string' => 'The name must be a string.',
            'name.max' => 'The name must not exceed 255 characters.',

            'phone_no.required' => 'The phone number is required.',
            'phone_no.regex' => 'Please enter a valid Bangladeshi phone number (e.g., 01712345678, +8801712345678).',

            'email.required' => 'The email field is required.',
            'email.email' => 'Please enter a valid email address.',
            'email.lowercase' => 'The email address must be in lowercase.',
            'email.max' => 'The email must not exceed 255 characters.',
            'email.unique' => 'This email is already registered.',

            'password.required' => 'The password field is required.',
            'password.confirmed' => 'The password confirmation does not match.',
            'password.min' => 'The password must be at least 8 characters.',
            'password.regex' => 'The password must contain at least one uppercase letter, one number, and one special character.',
        ];
    }
}

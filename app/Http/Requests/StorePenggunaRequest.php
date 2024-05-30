<?php

namespace App\Http\Requests;

use App\Models\Pengguna;
use Illuminate\Foundation\Http\FormRequest;

class StorePenggunaRequest extends FormRequest
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
            'nama' => 'required|string',
            'nomor_telepon' => 'nullable|string',
            'alamat' => 'nullable|string',
            'role' => 'required|string',
            'email' => [
                'required',
                'email',
                function ($value, $fail) {
                    //cek email yang terdaftar
                    $existingEmail = Pengguna::where('email', $value)->exists();
                    if ($existingEmail) {
                        $fail('Email Pengguna telah terdaftar.');
                    }
                }
            ],
            'password' => 'required|string',
        ];
    }
}

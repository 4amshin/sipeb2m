<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBajuRequest extends FormRequest
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
            'nama_baju' => 'sometimes|required|string|max:255',
            'gambar_baju' => 'nullable|image|mimes:jpeg,png,jpg',
            'ukuran' => 'sometimes|required|in:S,M,L,XL,XXL',
            'stok' => 'sometimes|required|integer|min:1',
            'harga_sewa_perhari' => 'sometimes|required|numeric|min:0',
        ];
    }
}

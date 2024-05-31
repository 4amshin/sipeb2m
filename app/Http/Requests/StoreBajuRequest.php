<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBajuRequest extends FormRequest
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
            'nama_baju' => 'required|string|max:255',
            'gambar_baju' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'ukuran' => 'required|in:S,M,L,XL,XXL',
            'stok' => 'required|integer|min:1',
            'harga_sewa_perhari' => 'required|numeric|min:0',
        ];
    }
}

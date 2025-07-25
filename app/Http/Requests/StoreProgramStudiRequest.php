<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProgramStudiRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:10|unique:program_studis,code',
            'degree_level' => 'required|in:D3,S1,S2,S3',
            'description' => 'nullable|string',
            'overview' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'accreditation' => 'nullable|string|max:10',
            'accreditation_date' => 'nullable|date',
            'accreditation_expire' => 'nullable|date|after:accreditation_date',
            'head_of_program' => 'nullable|string|max:255',
            'established_year' => 'nullable|integer|min:1900|max:' . date('Y'),
            'is_active' => 'boolean'
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Nama program studi wajib diisi.',
            'code.required' => 'Kode program studi wajib diisi.',
            'code.unique' => 'Kode program studi sudah digunakan.',
            'degree_level.required' => 'Jenjang pendidikan wajib dipilih.',
            'degree_level.in' => 'Jenjang pendidikan tidak valid.',
            'image.image' => 'File harus berupa gambar.',
            'image.max' => 'Ukuran gambar maksimal 2MB.',
            'accreditation_expire.after' => 'Tanggal expire harus setelah tanggal akreditasi.',
            'established_year.min' => 'Tahun berdiri tidak valid.',
            'established_year.max' => 'Tahun berdiri tidak boleh melebihi tahun ini.'
        ];
    }
}

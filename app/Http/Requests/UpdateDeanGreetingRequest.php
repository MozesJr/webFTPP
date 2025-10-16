<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateDeanGreetingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'section_title' => ['required', 'string', 'max:255'],
            'section_subtitle' => ['required', 'string', 'max:255'],
            'greeting_text' => ['required', 'string'],
            'dean_name' => ['required', 'string', 'max:255'],
            'dean_title' => ['nullable', 'string', 'max:100'],
            'dean_degree' => ['nullable', 'string', 'max:100'],
            'dean_photo' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
            'is_active' => ['boolean'],
            'display_order' => ['integer', 'min:0'],
            'remove_photo' => ['boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'section_title.required' => 'Judul section wajib diisi.',
            'section_subtitle.required' => 'Subtitle section wajib diisi.',
            'greeting_text.required' => 'Teks sambutan wajib diisi.',
            'dean_name.required' => 'Nama dekan wajib diisi.',
            'dean_photo.image' => 'File harus berupa gambar.',
            'dean_photo.mimes' => 'Foto harus berformat: jpeg, png, jpg, atau webp.',
            'dean_photo.max' => 'Ukuran foto maksimal 2MB.',
        ];
    }
}

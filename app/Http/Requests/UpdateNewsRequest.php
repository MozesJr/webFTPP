<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateNewsRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'excerpt' => 'required|string|max:500',
            'content' => 'required|string',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'category_id' => 'required|exists:news_categories,id',
            'status' => 'required|in:draft,published,archived',
            'published_at' => 'nullable|date',
            'is_featured' => 'boolean',
            'tags' => 'nullable|array',
            'tags.*' => 'string|max:50',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:300'
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'Judul berita wajib diisi.',
            'excerpt.required' => 'Ringkasan berita wajib diisi.',
            'content.required' => 'Konten berita wajib diisi.',
            'category_id.required' => 'Kategori berita wajib dipilih.',
            'category_id.exists' => 'Kategori berita tidak valid.',
            'featured_image.image' => 'File harus berupa gambar.',
            'featured_image.max' => 'Ukuran gambar maksimal 2MB.',
            'status.in' => 'Status berita tidak valid.'
        ];
    }

    protected function prepareForValidation()
    {
        // Convert tags from string to array if needed
        if ($this->tags && is_string($this->tags)) {
            $this->merge([
                'tags' => array_map('trim', explode(',', $this->tags))
            ]);
        }
    }
}

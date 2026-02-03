<script setup>
import { ref } from "vue";
import { router, useForm } from "@inertiajs/vue3";
import AdminLayout from "@/Layouts/AdminLayout.vue";

const props = defineProps({
    strukturOrganisasi: Object,
});

const form = useForm({
    nama: props.strukturOrganisasi.nama,
    nip: props.strukturOrganisasi.nip,
    jabatan: props.strukturOrganisasi.jabatan,
    email: props.strukturOrganisasi.email,
    phone: props.strukturOrganisasi.phone,
    photo: null,
    tugas_fungsi: props.strukturOrganisasi.tugas_fungsi,
    bio: props.strukturOrganisasi.bio,
    order: props.strukturOrganisasi.order,
    is_active: props.strukturOrganisasi.is_active,
    is_featured: props.strukturOrganisasi.is_featured,
    _method: "PUT",
});

const photoPreview = ref(props.strukturOrganisasi.photo_url || null);
const hasNewPhoto = ref(false);

const handlePhotoChange = (e) => {
    const file = e.target.files[0];
    if (file) {
        form.photo = file;
        hasNewPhoto.value = true;
        const reader = new FileReader();
        reader.onload = (e) => {
            photoPreview.value = e.target.result;
        };
        reader.readAsDataURL(file);
    }
};

const removePhoto = () => {
    form.photo = null;
    hasNewPhoto.value = false;
    photoPreview.value = props.strukturOrganisasi.photo_url || null;
    const input = document.getElementById("photo-input");
    if (input) input.value = "";
};

const submit = () => {
    form.post(
        route(
            "admin.gpm.struktur-organisasi.update",
            props.strukturOrganisasi.id,
        ),
        {
            preserveScroll: true,
            forceFormData: true, // ✅ CRITICAL: Force multipart/form-data
        },
    );
};
</script>

<template>
    <AdminLayout>
        <div class="py-6">
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
                <!-- Header -->
                <div class="mb-6">
                    <a
                        :href="route('admin.gpm.struktur-organisasi.index')"
                        class="inline-flex items-center text-sm text-gray-600 hover:text-gray-900 mb-4"
                    >
                        <svg
                            class="w-4 h-4 mr-1"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M10 19l-7-7m0 0l7-7m-7 7h18"
                            />
                        </svg>
                        Kembali
                    </a>
                    <h2 class="text-2xl font-bold text-gray-900">
                        Edit Anggota GPM
                    </h2>
                    <p class="mt-1 text-sm text-gray-500">
                        Edit data anggota Struktur Organisasi GPM
                    </p>
                </div>

                <!-- Form -->
                <form
                    @submit.prevent="submit"
                    class="bg-white shadow rounded-lg p-6"
                >
                    <!-- Photo Upload -->
                    <div class="mb-6">
                        <label
                            class="block text-sm font-medium text-gray-700 mb-2"
                            >Foto Profil</label
                        >
                        <div class="flex items-center space-x-6">
                            <div class="flex-shrink-0">
                                <div class="relative">
                                    <img
                                        :src="
                                            photoPreview ||
                                            '/images/default-avatar.png'
                                        "
                                        alt="Preview"
                                        class="h-32 w-32 rounded-full object-cover border-4 border-gray-200"
                                    />
                                    <button
                                        v-if="hasNewPhoto"
                                        @click="removePhoto"
                                        type="button"
                                        class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full p-1 hover:bg-red-600"
                                    >
                                        <svg
                                            class="w-4 h-4"
                                            fill="none"
                                            stroke="currentColor"
                                            viewBox="0 0 24 24"
                                        >
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M6 18L18 6M6 6l12 12"
                                            />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                            <div class="flex-1">
                                <input
                                    id="photo-input"
                                    type="file"
                                    accept="image/*"
                                    @change="handlePhotoChange"
                                    class="hidden"
                                />
                                <label
                                    for="photo-input"
                                    class="cursor-pointer inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50"
                                >
                                    {{
                                        hasNewPhoto
                                            ? "Ganti Foto Lain"
                                            : "Ganti Foto"
                                    }}
                                </label>
                                <p class="mt-2 text-xs text-gray-500">
                                    JPG, PNG atau GIF. Maksimal 2MB.
                                </p>
                                <p
                                    v-if="form.errors.photo"
                                    class="mt-1 text-sm text-red-600"
                                >
                                    {{ form.errors.photo }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                        <!-- Nama -->
                        <div class="sm:col-span-2">
                            <label
                                class="block text-sm font-medium text-gray-700"
                            >
                                Nama Lengkap <span class="text-red-500">*</span>
                            </label>
                            <input
                                v-model="form.nama"
                                type="text"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                :class="{ 'border-red-500': form.errors.nama }"
                            />
                            <p
                                v-if="form.errors.nama"
                                class="mt-1 text-sm text-red-600"
                            >
                                {{ form.errors.nama }}
                            </p>
                        </div>

                        <!-- NIP -->
                        <div>
                            <label
                                class="block text-sm font-medium text-gray-700"
                                >NIP</label
                            >
                            <input
                                v-model="form.nip"
                                type="text"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                :class="{ 'border-red-500': form.errors.nip }"
                            />
                            <p
                                v-if="form.errors.nip"
                                class="mt-1 text-sm text-red-600"
                            >
                                {{ form.errors.nip }}
                            </p>
                        </div>

                        <!-- Jabatan -->
                        <div>
                            <label
                                class="block text-sm font-medium text-gray-700"
                            >
                                Jabatan <span class="text-red-500">*</span>
                            </label>
                            <input
                                v-model="form.jabatan"
                                type="text"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                :class="{
                                    'border-red-500': form.errors.jabatan,
                                }"
                            />
                            <p
                                v-if="form.errors.jabatan"
                                class="mt-1 text-sm text-red-600"
                            >
                                {{ form.errors.jabatan }}
                            </p>
                        </div>

                        <!-- Email -->
                        <div>
                            <label
                                class="block text-sm font-medium text-gray-700"
                                >Email</label
                            >
                            <input
                                v-model="form.email"
                                type="email"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                :class="{ 'border-red-500': form.errors.email }"
                            />
                            <p
                                v-if="form.errors.email"
                                class="mt-1 text-sm text-red-600"
                            >
                                {{ form.errors.email }}
                            </p>
                        </div>

                        <!-- Phone -->
                        <div>
                            <label
                                class="block text-sm font-medium text-gray-700"
                                >No. Telepon</label
                            >
                            <input
                                v-model="form.phone"
                                type="text"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                :class="{ 'border-red-500': form.errors.phone }"
                            />
                            <p
                                v-if="form.errors.phone"
                                class="mt-1 text-sm text-red-600"
                            >
                                {{ form.errors.phone }}
                            </p>
                        </div>

                        <!-- Order -->
                        <div>
                            <label
                                class="block text-sm font-medium text-gray-700"
                                >Urutan Tampil</label
                            >
                            <input
                                v-model.number="form.order"
                                type="number"
                                min="1"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                :class="{ 'border-red-500': form.errors.order }"
                            />
                            <p
                                v-if="form.errors.order"
                                class="mt-1 text-sm text-red-600"
                            >
                                {{ form.errors.order }}
                            </p>
                            <p class="mt-1 text-xs text-gray-500">
                                Angka lebih kecil akan tampil lebih dahulu
                            </p>
                        </div>

                        <!-- Tugas & Fungsi -->
                        <div class="sm:col-span-2">
                            <label
                                class="block text-sm font-medium text-gray-700"
                                >Tugas & Fungsi</label
                            >
                            <textarea
                                v-model="form.tugas_fungsi"
                                rows="4"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                :class="{
                                    'border-red-500': form.errors.tugas_fungsi,
                                }"
                            ></textarea>
                            <p
                                v-if="form.errors.tugas_fungsi"
                                class="mt-1 text-sm text-red-600"
                            >
                                {{ form.errors.tugas_fungsi }}
                            </p>
                        </div>

                        <!-- Bio -->
                        <div class="sm:col-span-2">
                            <label
                                class="block text-sm font-medium text-gray-700"
                                >Biografi Singkat</label
                            >
                            <textarea
                                v-model="form.bio"
                                rows="3"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                :class="{ 'border-red-500': form.errors.bio }"
                            ></textarea>
                            <p
                                v-if="form.errors.bio"
                                class="mt-1 text-sm text-red-600"
                            >
                                {{ form.errors.bio }}
                            </p>
                        </div>

                        <!-- Checkboxes -->
                        <div class="sm:col-span-2 space-y-4">
                            <label class="flex items-center">
                                <input
                                    v-model="form.is_active"
                                    type="checkbox"
                                    class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                />
                                <span class="ml-2 text-sm text-gray-700"
                                    >Aktif</span
                                >
                            </label>

                            <label class="flex items-center">
                                <input
                                    v-model="form.is_featured"
                                    type="checkbox"
                                    class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                />
                                <span class="ml-2 text-sm text-gray-700"
                                    >Featured (Posisi Utama)</span
                                >
                            </label>
                        </div>
                    </div>

                    <!-- Buttons -->
                    <div class="mt-6 flex items-center justify-end gap-3">
                        <a
                            :href="route('admin.gpm.struktur-organisasi.index')"
                            class="px-4 py-2 bg-white border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50"
                        >
                            Batal
                        </a>
                        <button
                            type="submit"
                            :disabled="form.processing"
                            class="px-4 py-2 bg-blue-600 border border-transparent rounded-md text-sm font-medium text-white hover:bg-blue-700 disabled:opacity-50"
                        >
                            <span v-if="form.processing">Menyimpan...</span>
                            <span v-else>Simpan Perubahan</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </AdminLayout>
</template>

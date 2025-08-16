<template>
    <AdminLayout>
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 mb-6">
            <div class="px-6 py-4 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">
                            Edit Role
                        </h1>
                        <p class="text-sm text-gray-600 mt-1">
                            Edit role "{{ role.name }}" dan kelola permission
                        </p>
                    </div>
                    <Link
                        :href="route('super-admin.roles.index')"
                        class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150"
                    >
                        <ArrowLeftIcon class="w-4 h-4 mr-2" />
                        Kembali
                    </Link>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm border border-gray-200">
            <form @submit.prevent="handleSubmit" class="p-6">
                <!-- Role Name -->
                <div class="mb-6">
                    <label
                        for="name"
                        class="block text-sm font-medium text-gray-700 mb-2"
                    >
                        Nama Role <span class="text-red-500">*</span>
                    </label>
                    <input
                        id="name"
                        type="text"
                        v-model="form.name"
                        :disabled="role.name === 'super_admin'"
                        :class="[
                            'w-full px-3 py-2 border rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500',
                            errors.name ? 'border-red-300' : 'border-gray-300',
                            role.name === 'super_admin'
                                ? 'bg-gray-100 cursor-not-allowed'
                                : '',
                        ]"
                        placeholder="Masukkan nama role..."
                        required
                    />
                    <p
                        v-if="role.name === 'super_admin'"
                        class="mt-1 text-xs text-yellow-600"
                    >
                        Nama role Super Admin tidak dapat diubah
                    </p>
                    <p v-if="errors.name" class="mt-1 text-sm text-red-600">
                        {{ errors.name }}
                    </p>
                </div>

                <!-- Permissions -->
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-4">
                        Permissions
                    </label>
                    <div class="space-y-6">
                        <div
                            v-for="(permissionGroup, groupName) in permissions"
                            :key="groupName"
                        >
                            <div
                                class="bg-gray-50 px-4 py-2 rounded-t-lg border"
                            >
                                <div class="flex items-center">
                                    <input
                                        :id="`group-${groupName}`"
                                        type="checkbox"
                                        :checked="
                                            isGroupSelected(permissionGroup)
                                        "
                                        @change="
                                            toggleGroup(
                                                permissionGroup,
                                                $event.target.checked
                                            )
                                        "
                                        class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded"
                                    />
                                    <label
                                        :for="`group-${groupName}`"
                                        class="ml-2 text-sm font-medium text-gray-900 capitalize"
                                    >
                                        {{ groupName }} ({{
                                            permissionGroup.length
                                        }})
                                    </label>
                                </div>
                            </div>
                            <div
                                class="border-l border-r border-b border-gray-200 rounded-b-lg p-4"
                            >
                                <div
                                    class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3"
                                >
                                    <div
                                        v-for="permission in permissionGroup"
                                        :key="permission.id"
                                        class="flex items-center"
                                    >
                                        <input
                                            :id="`permission-${permission.id}`"
                                            type="checkbox"
                                            :value="permission.name"
                                            v-model="form.permissions"
                                            class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded"
                                        />
                                        <label
                                            :for="`permission-${permission.id}`"
                                            class="ml-2 text-sm text-gray-700"
                                        >
                                            {{ permission.name }}
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Actions -->
                <div class="flex justify-end space-x-3">
                    <Link
                        :href="route('super-admin.roles.index')"
                        class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150"
                    >
                        Batal
                    </Link>
                    <button
                        type="submit"
                        :disabled="processing"
                        class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 disabled:opacity-50"
                    >
                        <span v-if="processing">Menyimpan...</span>
                        <span v-else>Update Role</span>
                    </button>
                </div>
            </form>
        </div>
    </AdminLayout>
</template>

<script setup>
import { ref } from "vue";
import { Link, useForm } from "@inertiajs/vue3";
import AdminLayout from "@/Layouts/AdminLayout.vue";
import { ArrowLeftIcon } from "@heroicons/vue/24/outline";

// Props
const props = defineProps({
    role: {
        type: Object,
        required: true,
    },
    permissions: {
        type: Object,
        default: () => ({}),
    },
});

// Form
const form = useForm({
    name: props.role.name,
    permissions: props.role.permissions
        ? props.role.permissions.map((p) => p.name)
        : [],
});

const processing = ref(false);
const errors = ref({});

// Methods
const isGroupSelected = (permissionGroup) => {
    return permissionGroup.every((permission) =>
        form.permissions.includes(permission.name)
    );
};

const toggleGroup = (permissionGroup, checked) => {
    if (checked) {
        // Add all permissions in the group
        permissionGroup.forEach((permission) => {
            if (!form.permissions.includes(permission.name)) {
                form.permissions.push(permission.name);
            }
        });
    } else {
        // Remove all permissions in the group
        permissionGroup.forEach((permission) => {
            const index = form.permissions.indexOf(permission.name);
            if (index > -1) {
                form.permissions.splice(index, 1);
            }
        });
    }
};

const handleSubmit = () => {
    processing.value = true;
    errors.value = {};

    form.put(route("super-admin.roles.update", props.role.id), {
        onSuccess: () => {
            processing.value = false;
        },
        onError: (responseErrors) => {
            processing.value = false;
            errors.value = responseErrors;
        },
    });
};
</script>

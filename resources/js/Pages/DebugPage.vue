<template>
    <div class="p-8">
        <h1 class="text-2xl font-bold mb-4">Debug Inertia Props</h1>

        <div class="bg-gray-100 p-4 rounded mb-4">
            <h2 class="font-bold">Test Message:</h2>
            <p>{{ testMessage }}</p>
        </div>

        <div class="bg-blue-100 p-4 rounded mb-4">
            <h2 class="font-bold">Auth Props:</h2>
            <pre>{{ JSON.stringify($page.props.auth, null, 2) }}</pre>
        </div>

        <div class="bg-green-100 p-4 rounded mb-4">
            <h2 class="font-bold">All Props:</h2>
            <pre>{{ JSON.stringify($page.props, null, 2) }}</pre>
        </div>

        <div class="bg-yellow-100 p-4 rounded">
            <h2 class="font-bold">Role Checks:</h2>
            <p>Is Super Admin: {{ $page.props.auth?.is_super_admin }}</p>
            <p>Roles: {{ $page.props.auth?.roles }}</p>
            <p>User: {{ $page.props.auth?.user?.name }}</p>
        </div>
    </div>
</template>

<script setup>
defineProps({
    testMessage: String,
});
</script>

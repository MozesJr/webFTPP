<template>
    <section class="bg-blue-600 text-white">
        <div class="container mx-auto px-4 py-16">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8 text-center">
                <div class="stat-item">
                    <div class="stat-number">
                        {{ formatNumber(stats.total_students) }}
                    </div>
                    <div class="stat-label">Mahasiswa</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number">
                        {{ formatNumber(stats.total_lecturers) }}
                    </div>
                    <div class="stat-label">Dosen</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number">
                        {{ formatNumber(stats.total_alumni) }}
                    </div>
                    <div class="stat-label">Alumni</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number">
                        {{ formatNumber(stats.total_partnerships) }}
                    </div>
                    <div class="stat-label">Mitra Kerja</div>
                </div>
            </div>
        </div>
    </section>
</template>

<script setup>
defineProps({
    stats: {
        type: Object,
        required: true,
    },
});

function formatNumber(num) {
    return new Intl.NumberFormat("id-ID").format(num);
}
</script>

<style scoped>
.stat-number {
    @apply text-4xl md:text-5xl font-bold mb-2;
}

.stat-label {
    @apply text-lg opacity-90;
}
</style>

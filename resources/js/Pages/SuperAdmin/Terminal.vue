<template>
    <AdminLayout>
        <div class="py-6">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

                <!-- Header -->
                <div class="bg-gradient-to-r from-gray-800 to-gray-900 rounded-t-lg shadow-lg px-6 py-4 flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <!-- Tombol dekoratif ala macOS -->
                        <span class="w-3 h-3 rounded-full bg-red-500 inline-block"></span>
                        <span class="w-3 h-3 rounded-full bg-yellow-400 inline-block"></span>
                        <span class="w-3 h-3 rounded-full bg-green-500 inline-block"></span>
                        <span class="ml-4 text-gray-300 text-sm font-mono">
                            Web Terminal — {{ user.name }} ({{ user.email }})
                        </span>
                    </div>
                    <div class="flex items-center gap-2">
                        <span
                            class="text-xs px-2 py-1 rounded font-mono"
                            :class="statusClass"
                        >
                            {{ statusLabel }}
                        </span>
                        <button
                            @click="clearOutput"
                            class="text-xs text-gray-400 hover:text-white transition px-2 py-1 rounded border border-gray-600 hover:border-gray-400"
                        >
                            Clear
                        </button>
                    </div>
                </div>

                <!-- Output Area -->
                <div
                    ref="outputEl"
                    class="bg-gray-950 font-mono text-sm text-gray-100 h-[60vh] overflow-y-auto px-4 py-3 space-y-0.5 border-x border-gray-700"
                    @click="focusInput"
                >
                    <!-- Pesan selamat datang -->
                    <div class="text-green-400 mb-3 select-none">
                        <p>╔══════════════════════════════════════════╗</p>
                        <p>║  FTPP Faculty Web Terminal               ║</p>
                        <p>║  Working dir: {{ basePath }}         ║</p>
                        <p>╚══════════════════════════════════════════╝</p>
                        <p class="mt-1 text-yellow-400">⚠  Setiap perintah dieksekusi di server. Gunakan dengan bijak.</p>
                        <p class="text-gray-500">─────────────────────────────────────────────</p>
                    </div>

                    <!-- Riwayat output -->
                    <div v-for="(entry, idx) in outputHistory" :key="idx">
                        <!-- Prompt baris perintah -->
                        <div class="flex items-start gap-2 mt-2">
                            <span class="text-green-400 shrink-0 select-none">$</span>
                            <span class="text-white">{{ entry.command }}</span>
                        </div>

                        <!-- Baris-baris output -->
                        <div
                            v-for="(line, li) in entry.lines"
                            :key="li"
                            class="pl-4 whitespace-pre-wrap break-all"
                            :class="entry.hasError && li === entry.lines.length - 1 ? 'text-red-400' : 'text-gray-300'"
                        >{{ line }}</div>

                        <!-- Status selesai -->
                        <div
                            v-if="entry.done"
                            class="pl-4 text-xs mt-0.5"
                            :class="entry.exitCode === 0 ? 'text-green-500' : 'text-red-400'"
                        >
                            [exit {{ entry.exitCode }}]
                        </div>
                    </div>

                    <!-- Entri yang sedang berjalan -->
                    <div v-if="running">
                        <div class="flex items-start gap-2 mt-2">
                            <span class="text-green-400 shrink-0 select-none">$</span>
                            <span class="text-white">{{ currentCommand }}</span>
                        </div>
                        <div
                            v-for="(line, li) in liveLines"
                            :key="'live-' + li"
                            class="pl-4 whitespace-pre-wrap break-all text-gray-300"
                        >{{ line }}</div>
                        <div class="pl-4 flex items-center gap-1 text-yellow-400 text-xs mt-0.5">
                            <span class="animate-pulse">▌</span>
                            <span>berjalan…</span>
                        </div>
                    </div>
                </div>

                <!-- Input Area -->
                <div class="bg-gray-900 border border-gray-700 rounded-b-lg px-4 py-3 flex items-center gap-3">
                    <span class="text-green-400 font-mono shrink-0 select-none">$</span>
                    <input
                        ref="inputEl"
                        v-model="commandInput"
                        @keydown.enter="runCommand"
                        @keydown.up.prevent="navigateHistory(-1)"
                        @keydown.down.prevent="navigateHistory(1)"
                        @keydown.ctrl.c.prevent="cancelCommand"
                        :disabled="running"
                        type="text"
                        placeholder="Ketik perintah dan tekan Enter…"
                        class="flex-1 bg-transparent text-white font-mono text-sm outline-none placeholder-gray-600 disabled:opacity-40"
                        autocomplete="off"
                        spellcheck="false"
                    />
                    <button
                        v-if="running"
                        @click="cancelCommand"
                        class="text-xs text-red-400 hover:text-red-300 border border-red-700 hover:border-red-500 px-2 py-1 rounded transition"
                    >
                        Ctrl+C
                    </button>
                    <button
                        v-else
                        @click="runCommand"
                        :disabled="!commandInput.trim()"
                        class="text-xs text-gray-400 hover:text-white border border-gray-600 hover:border-gray-400 px-2 py-1 rounded transition disabled:opacity-30 disabled:cursor-not-allowed"
                    >
                        Enter ↵
                    </button>
                </div>

                <!-- Panduan -->
                <div class="mt-3 text-xs text-gray-500 font-mono flex flex-wrap gap-x-6 gap-y-1">
                    <span>↑↓ riwayat perintah</span>
                    <span>Ctrl+C batalkan</span>
                    <span>Klik area output untuk fokus</span>
                    <span class="text-yellow-600">Timeout eksekusi: 60 detik</span>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>

<script setup>
import { ref, computed, nextTick } from 'vue'
import AdminLayout from '@/Layouts/AdminLayout.vue'
import { router } from '@inertiajs/vue3'

const props = defineProps({
    user: { type: Object, required: true },
})

// State
const commandInput  = ref('')
const outputHistory = ref([])   // [{ command, lines[], done, exitCode, hasError }]
const liveLines     = ref([])
const currentCommand = ref('')
const running       = ref(false)
const inputEl       = ref(null)
const outputEl      = ref(null)
const cmdHistory    = ref([])   // untuk navigasi ↑↓
const historyIndex  = ref(-1)

const basePath = '/var/www/html'

// Computed
const statusLabel = computed(() => running.value ? '● RUNNING' : '○ READY')
const statusClass = computed(() => running.value
    ? 'bg-yellow-900 text-yellow-400 border border-yellow-700'
    : 'bg-green-950 text-green-400 border border-green-800'
)

// EventSource aktif (untuk cancel)
let eventSource = null

function focusInput() {
    inputEl.value?.focus()
}

function clearOutput() {
    outputHistory.value = []
}

function scrollToBottom() {
    nextTick(() => {
        if (outputEl.value) {
            outputEl.value.scrollTop = outputEl.value.scrollHeight
        }
    })
}

function navigateHistory(direction) {
    if (cmdHistory.value.length === 0) return
    historyIndex.value = Math.max(
        -1,
        Math.min(cmdHistory.value.length - 1, historyIndex.value + direction)
    )
    commandInput.value = historyIndex.value >= 0
        ? cmdHistory.value[cmdHistory.value.length - 1 - historyIndex.value]
        : ''
}

function cancelCommand() {
    if (eventSource) {
        eventSource.close()
        eventSource = null
    }
    if (running.value) {
        liveLines.value.push('[Dibatalkan oleh pengguna]')
        pushLiveToHistory(null, true)
    }
}

function pushLiveToHistory(exitCode, cancelled = false) {
    outputHistory.value.push({
        command:  currentCommand.value,
        lines:    [...liveLines.value],
        done:     true,
        exitCode: cancelled ? -1 : exitCode,
        hasError: cancelled || exitCode !== 0,
    })
    liveLines.value    = []
    currentCommand.value = ''
    running.value       = false
    scrollToBottom()
    nextTick(() => inputEl.value?.focus())
}

async function runCommand() {
    const cmd = commandInput.value.trim()
    if (!cmd || running.value) return

    // Simpan ke riwayat navigasi
    cmdHistory.value.push(cmd)
    historyIndex.value  = -1
    commandInput.value  = ''
    running.value       = true
    currentCommand.value = cmd
    liveLines.value     = []

    scrollToBottom()

    // Bangun URL SSE dengan query string
    const url = new URL(route('super-admin.terminal.stream'), window.location.origin)
    url.searchParams.set('command', cmd)

    eventSource = new EventSource(url.toString())

    eventSource.onmessage = (event) => {
        if (event.data === '[DONE]') {
            eventSource.close()
            eventSource = null
            // Jika belum ada sinyal 'done', tutup saja
            if (running.value) {
                pushLiveToHistory(0)
            }
            return
        }

        let payload
        try {
            payload = JSON.parse(event.data)
        } catch {
            return
        }

        if (payload.type === 'output') {
            liveLines.value.push(payload.line)
            scrollToBottom()
        } else if (payload.type === 'done') {
            pushLiveToHistory(payload.exit_code)
        } else if (payload.type === 'error') {
            liveLines.value.push('ERROR: ' + payload.message)
            pushLiveToHistory(1)
        }
    }

    eventSource.onerror = () => {
        if (running.value) {
            liveLines.value.push('[Koneksi SSE terputus]')
            pushLiveToHistory(1)
        }
        eventSource?.close()
        eventSource = null
    }
}
</script>

<template>
    <AdminLayout>
        <div class="py-6">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

                <!-- Tombol Auto-Deploy -->
                <div class="mb-4 flex items-center justify-between">
                    <div>
                        <h1 class="text-lg font-semibold text-gray-800">Web Terminal</h1>
                        <p class="text-xs text-gray-500 mt-0.5">Working dir: <code class="font-mono bg-gray-100 px-1 rounded">{{ basePath }}</code></p>
                    </div>

                    <button
                        @click="runDeploy"
                        :disabled="running"
                        class="flex items-center gap-2 px-4 py-2 rounded-lg text-sm font-semibold transition-all shadow-sm"
                        :class="running
                            ? 'bg-gray-200 text-gray-400 cursor-not-allowed'
                            : 'bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white hover:shadow-md'"
                    >
                        <span>🚀</span>
                        <span>Fetch &amp; Deploy Update</span>
                        <span v-if="running && deployMode" class="w-3 h-3 border-2 border-white border-t-transparent rounded-full animate-spin"></span>
                    </button>
                </div>

                <!-- Header Terminal -->
                <div class="bg-gradient-to-r from-gray-800 to-gray-900 rounded-t-lg shadow-lg px-6 py-4 flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <span class="w-3 h-3 rounded-full bg-red-500 inline-block"></span>
                        <span class="w-3 h-3 rounded-full bg-yellow-400 inline-block"></span>
                        <span class="w-3 h-3 rounded-full bg-green-500 inline-block"></span>
                        <span class="ml-4 text-gray-300 text-sm font-mono">
                            {{ user.name }} ({{ user.email }})
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
                            :disabled="running"
                            class="text-xs text-gray-400 hover:text-white transition px-2 py-1 rounded border border-gray-600 hover:border-gray-400 disabled:opacity-30 disabled:cursor-not-allowed"
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
                    <!-- Banner selamat datang -->
                    <div class="text-green-400 mb-3 select-none">
                        <p>╔══════════════════════════════════════════╗</p>
                        <p>║  FTPP Faculty Web Terminal               ║</p>
                        <p>╚══════════════════════════════════════════╝</p>
                        <p class="mt-1 text-yellow-400">⚠  Setiap perintah dieksekusi di server. Gunakan dengan bijak.</p>
                        <p class="text-gray-500">─────────────────────────────────────────────</p>
                    </div>

                    <!-- Riwayat output -->
                    <template v-for="(entry, idx) in outputHistory" :key="idx">
                        <!-- Header deploy -->
                        <div v-if="entry.isDeployHeader" class="mt-3">
                            <p class="text-purple-400 font-bold">{{ entry.message }}</p>
                        </div>

                        <!-- Header langkah deploy -->
                        <div v-else-if="entry.isStep" class="mt-3 border-t border-gray-800 pt-2">
                            <p class="text-cyan-400 text-xs">
                                ── Langkah {{ entry.step }}/{{ entry.total }}: <span class="text-white">{{ entry.command }}</span>
                            </p>
                        </div>

                        <!-- Status langkah deploy selesai -->
                        <div v-else-if="entry.isStepDone" class="pl-4 text-xs" :class="entry.success ? 'text-green-500' : 'text-red-400'">
                            {{ entry.success ? '✓ Berhasil' : `✗ Gagal (exit ${entry.exitCode})` }}
                        </div>

                        <!-- Notifikasi deploy success/failed -->
                        <div v-else-if="entry.isDeployResult" class="mt-2 px-3 py-2 rounded text-sm font-semibold" :class="entry.success ? 'bg-green-900 text-green-300' : 'bg-red-900 text-red-300'">
                            {{ entry.success ? '🎉' : '❌' }} {{ entry.message }}
                        </div>

                        <!-- Entri perintah biasa -->
                        <template v-else>
                            <div class="flex items-start gap-2 mt-2">
                                <span class="text-green-400 shrink-0 select-none">$</span>
                                <span class="text-white">{{ entry.command }}</span>
                            </div>
                            <div
                                v-for="(line, li) in entry.lines"
                                :key="li"
                                class="pl-4 whitespace-pre-wrap break-all"
                                :class="entry.hasError && li === entry.lines.length - 1 ? 'text-red-400' : 'text-gray-300'"
                            >{{ line }}</div>
                            <div
                                v-if="entry.done"
                                class="pl-4 text-xs mt-0.5"
                                :class="entry.exitCode === 0 ? 'text-green-500' : 'text-red-400'"
                            >
                                [exit {{ entry.exitCode }}]
                            </div>
                        </template>
                    </template>

                    <!-- Output streaming yang sedang berjalan -->
                    <div v-if="running">
                        <!-- Hanya tampilkan prompt untuk perintah manual (bukan deploy) -->
                        <div v-if="!deployMode" class="flex items-start gap-2 mt-2">
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
                            <span>{{ deployMode ? 'deploy berjalan…' : 'berjalan…' }}</span>
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
                    <span class="text-yellow-600">Timeout: 60 dtk (deploy: 120 dtk/langkah)</span>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>

<script setup>
import { ref, computed, nextTick } from 'vue'
import AdminLayout from '@/Layouts/AdminLayout.vue'

defineProps({
    user: { type: Object, required: true },
})

// ── State ──────────────────────────────────────────────────────────────────
const commandInput   = ref('')
const outputHistory  = ref([])
const liveLines      = ref([])
const currentCommand = ref('')
const running        = ref(false)
const deployMode     = ref(false)
const inputEl        = ref(null)
const outputEl       = ref(null)
const cmdHistory     = ref([])
const historyIndex   = ref(-1)

const basePath = '/var/www/html'

let eventSource = null

// ── Computed ───────────────────────────────────────────────────────────────
const statusLabel = computed(() => {
    if (!running.value) return '○ READY'
    return deployMode.value ? '⟳ DEPLOYING' : '● RUNNING'
})
const statusClass = computed(() => {
    if (!running.value) return 'bg-green-950 text-green-400 border border-green-800'
    return deployMode.value
        ? 'bg-purple-900 text-purple-300 border border-purple-700'
        : 'bg-yellow-900 text-yellow-400 border border-yellow-700'
})

// ── Helpers ────────────────────────────────────────────────────────────────
function focusInput() { inputEl.value?.focus() }

function clearOutput() { outputHistory.value = [] }

function scrollToBottom() {
    nextTick(() => {
        if (outputEl.value) outputEl.value.scrollTop = outputEl.value.scrollHeight
    })
}

function navigateHistory(direction) {
    if (!cmdHistory.value.length) return
    historyIndex.value = Math.max(-1, Math.min(cmdHistory.value.length - 1, historyIndex.value + direction))
    commandInput.value = historyIndex.value >= 0
        ? cmdHistory.value[cmdHistory.value.length - 1 - historyIndex.value]
        : ''
}

function cancelCommand() {
    eventSource?.close()
    eventSource = null
    if (running.value) {
        liveLines.value.push('[Dibatalkan oleh pengguna]')
        flushLiveLinesToHistory({ cancelled: true })
    }
}

function flushLiveLinesToHistory({ exitCode = 0, cancelled = false, command = null } = {}) {
    if (liveLines.value.length) {
        outputHistory.value.push({
            command:  command ?? currentCommand.value,
            lines:    [...liveLines.value],
            done:     true,
            exitCode: cancelled ? -1 : exitCode,
            hasError: cancelled || exitCode !== 0,
        })
        liveLines.value = []
    }
    currentCommand.value = ''
    running.value        = false
    deployMode.value     = false
    scrollToBottom()
    nextTick(() => inputEl.value?.focus())
}

// ── Perintah manual ────────────────────────────────────────────────────────
function runCommand() {
    const cmd = commandInput.value.trim()
    if (!cmd || running.value) return

    cmdHistory.value.push(cmd)
    historyIndex.value   = -1
    commandInput.value   = ''
    running.value        = true
    deployMode.value     = false
    currentCommand.value = cmd
    liveLines.value      = []
    scrollToBottom()

    const url = new URL(route('super-admin.terminal.stream'), window.location.origin)
    url.searchParams.set('command', cmd)

    openSSE(url.toString(), (payload) => {
        if (payload.type === 'output') {
            liveLines.value.push(payload.line)
            scrollToBottom()
        } else if (payload.type === 'done') {
            flushLiveLinesToHistory({ exitCode: payload.exit_code })
        } else if (payload.type === 'error') {
            liveLines.value.push('ERROR: ' + payload.message)
            flushLiveLinesToHistory({ exitCode: 1 })
        }
    })
}

// ── Auto-Deploy ────────────────────────────────────────────────────────────
function runDeploy() {
    if (running.value) return

    running.value    = true
    deployMode.value = true
    liveLines.value  = []
    scrollToBottom()

    const url = route('super-admin.terminal.deploy')

    openSSE(url, (payload) => {
        switch (payload.type) {
            case 'deploy_start':
                outputHistory.value.push({ isDeployHeader: true, message: payload.message })
                scrollToBottom()
                break

            case 'step':
                // Flush baris output langkah sebelumnya (jika ada) ke history
                if (liveLines.value.length) {
                    outputHistory.value.push({
                        command: null, lines: [...liveLines.value],
                        done: false, exitCode: null, hasError: false,
                    })
                    liveLines.value = []
                }
                outputHistory.value.push({
                    isStep:   true,
                    step:     payload.step,
                    total:    payload.total,
                    command:  payload.command,
                })
                scrollToBottom()
                break

            case 'output':
                liveLines.value.push(payload.line)
                scrollToBottom()
                break

            case 'step_done':
                // Flush output live ke history, lalu tambahkan status langkah
                if (liveLines.value.length) {
                    outputHistory.value.push({
                        command: null, lines: [...liveLines.value],
                        done: false, exitCode: null, hasError: false,
                    })
                    liveLines.value = []
                }
                outputHistory.value.push({
                    isStepDone: true,
                    step:       payload.step,
                    success:    payload.success,
                    exitCode:   payload.exit_code,
                })
                scrollToBottom()
                break

            case 'deploy_success':
            case 'deploy_failed':
                outputHistory.value.push({
                    isDeployResult: true,
                    success:        payload.type === 'deploy_success',
                    message:        payload.message,
                })
                running.value    = false
                deployMode.value = false
                scrollToBottom()
                nextTick(() => inputEl.value?.focus())
                break

            case 'error':
                liveLines.value.push('ERROR: ' + payload.message)
                flushLiveLinesToHistory({ exitCode: 1 })
                break
        }
    })
}

// ── SSE helper ─────────────────────────────────────────────────────────────
function openSSE(url, onPayload) {
    eventSource = new EventSource(url.toString())

    eventSource.onmessage = (event) => {
        if (event.data === '[DONE]') {
            eventSource.close()
            eventSource = null
            if (running.value) flushLiveLinesToHistory({ exitCode: 0 })
            return
        }
        let payload
        try { payload = JSON.parse(event.data) } catch { return }
        onPayload(payload)
    }

    eventSource.onerror = () => {
        if (running.value) {
            liveLines.value.push('[Koneksi SSE terputus]')
            flushLiveLinesToHistory({ exitCode: 1 })
        }
        eventSource?.close()
        eventSource = null
    }
}
</script>

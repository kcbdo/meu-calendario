<template>
    <div class="app">
        <nav class="navbar">
            <div class="navbar-brand">
                📅 Meu Calendário
            </div>
            <div class="navbar-actions">
                <button @click="toggleTheme()" class="btn-theme">
                    {{ isDark ? '☀️ Claro' : '🌙 Escuro' }}
                </button>
            </div>
        </nav>

        <main class="main-content">
            <slot />
        </main>
    </div>
</template>

<script setup>
import { ref } from 'vue'
import '../styles/layout.css'

const isDark = ref(false)

const toggleTheme = () => {
    isDark.value = !isDark.value
    document.body.classList.toggle('dark', isDark.value)
}
</script>

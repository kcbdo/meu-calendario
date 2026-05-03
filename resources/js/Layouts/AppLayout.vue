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
import { useTheme } from '../composables/useTheme'
import '../styles/layout.css'

const { isDark, toggleTheme } = useTheme()
</script>

import { ref } from 'vue'

export function useTheme() {
    const isDark = ref(false)

    const toggleTheme = () => {
        isDark.value = !isDark.value
        document.body.classList.toggle('dark', isDark.value)
    }

    return {
        isDark,
        toggleTheme,
    }
}

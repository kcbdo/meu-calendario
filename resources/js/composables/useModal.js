import { ref } from 'vue'

export function useModal() {
    const showModal = ref(false)
    const editingEvent = ref(null)

    const openModal = () => {
        editingEvent.value = null
        showModal.value = true
    }

    const openEditModal = (event) => {
        editingEvent.value = event
        showModal.value = true
    }

    const closeModal = () => {
        showModal.value = false
        editingEvent.value = null
    }

    return {
        showModal,
        editingEvent,
        openModal,
        openEditModal,
        closeModal,
    }
}

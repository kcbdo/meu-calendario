<template>
    <AppLayout>
        <CalendarView
            :events="events"
            @new-event="openModal"
            @edit-event="openEditModal"
            @drop-event="handleDrop"
        />

        <EventModal
            :show="showModal"
            :event="editingEvent"
            :errors="errors"
            @close="closeModal"
            @save="handleSave"
            @delete="handleDelete"
        />
    </AppLayout>
</template>

<script setup>
import { onMounted } from 'vue'
import AppLayout from '../Layouts/AppLayout.vue'
import CalendarView from '../Components/CalendarView.vue'
import EventModal from '../Components/EventModal.vue'
import { useEvents } from '../composables/useEvents'
import { useModal } from '../composables/useModal'

const { events, errors, fetchEvents, createEvent, updateEvent, deleteEvent } = useEvents()
const { showModal, editingEvent, openModal, openEditModal, closeModal } = useModal()

const handleSave = async (form) => {
    const success = editingEvent.value
        ? await updateEvent(editingEvent.value.id, form)
        : await createEvent(form)

    if (success) closeModal()
}

const handleDelete = async (id) => {
    if (!confirm('Deseja excluir este evento?')) return
    await deleteEvent(id)
    closeModal()
}

const handleDrop = async (event) => {
    await updateEvent(event.id, {
        title: event.title,
        start_datetime: event.startStr,
        end_datetime: event.endStr,
        color: event.backgroundColor,
    })
}

onMounted(() => {
    fetchEvents()
})
</script>

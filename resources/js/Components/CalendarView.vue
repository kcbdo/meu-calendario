<template>
    <div class="calendar-container">
        <header class="calendar-header">
            <h1>📅 Meu Calendário</h1>
            <button @click="$emit('new-event')" class="btn-new-event">
                + Novo Evento
            </button>
        </header>

        <FullCalendar :options="calendarOptions" />
    </div>
</template>

<script setup>
import { ref, watch } from 'vue'
import FullCalendar from '@fullcalendar/vue3'
import dayGridPlugin from '@fullcalendar/daygrid'
import timeGridPlugin from '@fullcalendar/timegrid'
import interactionPlugin from '@fullcalendar/interaction'
import ptBrLocale from '@fullcalendar/core/locales/pt-br'
import '../styles/calendar.css'

const props = defineProps({
    events: {
        type: Array,
        default: () => [],
    },
})

const emit = defineEmits(['new-event', 'edit-event', 'drop-event'])

const calendarOptions = ref({
    plugins: [dayGridPlugin, timeGridPlugin, interactionPlugin],
    initialView: 'dayGridMonth',
    locale: ptBrLocale,
    headerToolbar: {
        left: 'prev,next today',
        center: 'title',
        right: 'dayGridMonth,timeGridWeek,timeGridDay',
    },
    editable: true,
    selectable: true,
    events: [],
    select: (info) => {
        emit('new-event', { start: info.startStr, end: info.endStr })
    },
    eventClick: (info) => {
        emit('edit-event', info.event)
    },
    eventDrop: (info) => {
        emit('drop-event', info.event)
    },
})

watch(() => props.events, (events) => {
    calendarOptions.value.events = events
}, { immediate: true })
</script>

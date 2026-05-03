import { ref } from 'vue'

export function useEvents() {
    const events = ref([])
    const errors = ref({})

    const fetchEvents = async () => {
        const response = await fetch('/api/events')
        const data = await response.json()

        events.value = data.map(event => ({
            id: event.id,
            title: event.title,
            start: event.start_datetime,
            end: event.end_datetime,
            backgroundColor: event.color,
            borderColor: event.color,
            extendedProps: {
                description: event.description,
                reminder_at: event.reminder_at,
            }
        }))
    }

    const createEvent = async (form) => {
        errors.value = {}

        const response = await fetch('/api/events', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(form),
        })

        const data = await response.json()

        if (!response.ok) {
            errors.value = data.errors || {}
            return false
        }

        await fetchEvents()
        return true
    }

    const updateEvent = async (id, form) => {
        errors.value = {}

        const response = await fetch(`/api/events/${id}`, {
            method: 'PUT',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(form),
        })

        const data = await response.json()

        if (!response.ok) {
            errors.value = data.errors || {}
            return false
        }

        await fetchEvents()
        return true
    }

    const deleteEvent = async (id) => {
        await fetch(`/api/events/${id}`, { method: 'DELETE' })
        await fetchEvents()
        return true
    }

    return {
        events,
        errors,
        fetchEvents,
        createEvent,
        updateEvent,
        deleteEvent,
    }
}

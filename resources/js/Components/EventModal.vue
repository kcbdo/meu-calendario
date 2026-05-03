<template>
    <div v-if="show" class="modal-overlay" @click.self="$emit('close')">
        <div class="modal">
            <h2>{{ event ? 'Editar Evento' : 'Novo Evento' }}</h2>

            <div class="form-group">
                <label>Título *</label>
                <input v-model="form.title" type="text" placeholder="Nome do evento" />
                <span v-if="errors.title" class="error">{{ errors.title[0] }}</span>
            </div>

            <div class="form-group">
                <label>Descrição</label>
                <textarea v-model="form.description" placeholder="Descrição opcional"></textarea>
            </div>

            <div class="form-group">
                <label>Início *</label>
                <input v-model="form.start_datetime" type="datetime-local" />
                <span v-if="errors.start_datetime" class="error">{{ errors.start_datetime[0] }}</span>
            </div>

            <div class="form-group">
                <label>Término *</label>
                <input v-model="form.end_datetime" type="datetime-local" />
                <span v-if="errors.end_datetime" class="error">{{ errors.end_datetime[0] }}</span>
            </div>

            <div class="form-group">
                <label>Cor</label>
                <input v-model="form.color" type="color" />
            </div>

            <div class="form-group">
                <label>Lembrete</label>
                <input v-model="form.reminder_at" type="datetime-local" />
            </div>

            <div class="modal-actions">
                <button @click="$emit('close')" class="btn-cancel">Cancelar</button>
                <button v-if="event" @click="$emit('delete', event.id)" class="btn-delete">Excluir</button>
                <button @click="submit()" class="btn-save">Salvar</button>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, watch } from 'vue'
import '../styles/modal.css'

const props = defineProps({
    show: Boolean,
    event: Object,
    errors: {
        type: Object,
        default: () => ({})
    },
})

const emit = defineEmits(['close', 'save', 'delete'])

const form = ref({
    title: '',
    description: '',
    start_datetime: '',
    end_datetime: '',
    color: '#3B82F6',
    reminder_at: '',
})

watch(() => props.event, (event) => {
    if (event) {
        form.value = {
            title: event.title,
            description: event.extendedProps.description || '',
            start_datetime: event.startStr.slice(0, 16),
            end_datetime: event.endStr.slice(0, 16),
            color: event.backgroundColor || '#3B82F6',
            reminder_at: event.extendedProps.reminder_at || '',
        }
    } else {
        form.value = {
            title: '',
            description: '',
            start_datetime: '',
            end_datetime: '',
            color: '#3B82F6',
            reminder_at: '',
        }
    }
}, { immediate: true })

const submit = () => {
    emit('save', form.value)
}
</script>

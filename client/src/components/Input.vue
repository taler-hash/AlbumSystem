<template>
    <div class="input-wrapper">
        <div class="input-header">
            {{ props.title }}
        </div>
        <input :type="props.type" :value="props.modelValue" @input="updateInput" :placeholder="props.placeholder">
        <div class="input-errors">
            <p v-for="error in props.errors">
                {{ error }}
            </p>
        </div>
    </div>
</template>
<script lang="ts" setup>
import type { PropType } from 'vue'

const emit = defineEmits(['update:modelValue', 'keypress'])
const props = defineProps({
    title: { 
        type: String, 
    },
    errors: { 
        type: Array as PropType<string[]>, 
        required: false
    },
    modelValue: String,
    type: {
        type: String as PropType<'text' | 'password'>,
        required: true
    },

    placeholder: {
        type: String,
        required: false
    }
})

const updateInput = (event: Event) => {
    emit('keypress', (event.target as HTMLInputElement)?.value);
    emit('update:modelValue', (event.target as HTMLInputElement)?.value)
}
</script>
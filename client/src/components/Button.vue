<template>
    <button class="button" @click="onClickButton">{{ props.label }}</button>
</template>
<script lang="ts" setup>
const props = defineProps({
    label: {
        type: String,
        required: true
    }
})

const emit = defineEmits(['click'])

function onClickButton() {
    emit('click')
}
</script>
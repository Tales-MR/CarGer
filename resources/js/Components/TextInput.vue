<script setup>
import { onMounted, ref } from 'vue';

defineProps({
    modelValue: {
        type: String,
        required: true,
    },
});

defineEmits(['update:modelValue']);
</script>

<template>
    <input type="text"
           class="rounded-md shadow-sm d-flex"
           :value="modelValue"
           @input="$emit('update:modelValue', $event.target.value)"
           ref="input"/>
</template>

<style scoped>
input {
    border: 2px solid #FF9F47;
    width: 80vw;
}

input:focus  {
    border: 2px solid #FF9F47;
}
</style>

<script setup>
import { computed } from 'vue';

const props = defineProps({
    type: {
        type: String,
        default: 'secondary',
    },
});

const classObject = computed({
    get() {
        1;
        return {
            'bg-green-500': props.type === 'on',
            'bg-red-500': props.type === 'off',
            'bg-gray-500': props.type === 'secondary',
        };
    },
});
</script>

<template>
    <span class="flex h-3 w-3 rounded-full" :class="classObject"> </span>
</template>

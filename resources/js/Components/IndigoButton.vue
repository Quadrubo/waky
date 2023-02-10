<script setup>
defineProps({
    type: {
        type: String,
        default: 'button',
    },
});
</script>

<template>
    <button
        :type="type"
        class="inline-flex items-center justify-center rounded-md border border-transparent bg-indigo-600 px-4 py-2 text-xs font-semibold uppercase tracking-widest text-white transition hover:bg-indigo-500 focus:border-indigo-700 focus:outline-none focus:ring focus:ring-indigo-200 active:bg-indigo-600 disabled:opacity-25"
    >
        <slot />
    </button>
</template>

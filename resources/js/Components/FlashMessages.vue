<script setup>
import FlashMessage from '@/Components/BasicFlashMessage.vue';
import { ref } from 'vue';

let notifications = ref([]);

Echo.private('App.Models.User.1')
    .notification((notification) => {
        notifications.value.push(notification);
    });

</script>

<template>
    
    <div class="fixed inset-0 z-[90] px-4 py-6 pointer-events-none sm:p-6">
        <div class="flex flex-col items-end justify-start min-w-min space-y-2">
            <FlashMessage v-for="message, message_key in notifications" :key="message_key" :message="message" />
        </div>
    </div>

</template>
<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { router } from '@inertiajs/vue3';

let props = defineProps({
    computers: Object,
});

let wakeComputer = ((id) => {
    router.post(route('computers.wake', id));
});
</script>

<template>
    <AppLayout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Computers
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">

                    <table>
                        <thead>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Mac Address</th>
                            <th>IP Address</th>
                            <th>Wake-Up</th>
                            <th>Status</th>
                        </thead>
                        <tbody>
                            <tr v-for="computer, computer_key in computers" :key="computer_key">
                                <td>{{ computer.id }}</td>
                                <td>{{ computer.name }}</td>
                                <td>{{ computer.mac_address }}</td>
                                <td>{{ computer.ip_address }}</td>
                                <td><button @click="wakeComputer(computer.id)">Wake-up</button></td>
                                <td>Status</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { router } from '@inertiajs/vue3';

import StatusIndicator from '@/Components/StatusIndicator.vue';
import IndigoButton from '@/Components/IndigoButton.vue';

let props = defineProps({
    computers: Object,
});

let wakeComputer = ((id) => {
    router.post(route('computers.wake', id));
});

let pingComputers = (() => {
    router.post(route('computers.ping'));
});

let useComputer = ((id) => {
    router.post(route('computers.use', id));
});
</script>

<template>
    <AppLayout title="Computers">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Computers
            </h2>
            <IndigoButton @click="pingComputers">Refresh</IndigoButton>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="">
                    <div class="grid grid-cols-1 m-auto">

                        <!-- Mobile Table -->
                        <div class="md:hidden max-w-full px-2 space-y-4">
                            <div v-for="computer, computer_key in computers" :key="computer_key" class="bg-white overflow-hidden shadow-md rounded-md space-y-2 p-2">
                                <!-- {{ computer }} -->
        
                                <!-- Top row -->
                                <div class="flex flex-row justify-between items-center">
                                    <div class="flex flex-row items-center space-x-2">
                                        <span>
                                            <!-- On click show last updated at, only show the dot -->
                                            <StatusIndicator class="block m-auto" :type="computer.status">{{ computer.status }}</StatusIndicator>
                                        </span>
                                        <span class="text-xl">
                                            {{ computer.name }}
                                        </span>
                                    </div>
                                    <span>
                                        <IndigoButton @click="wakeComputer(computer.id)">Wake-up</IndigoButton>
                                    </span>
                                    <div class="space-x-2">
                                        <IndigoButton @click="useComputer(computer.id)">Use</IndigoButton>
                                        <span>{{ computer.users }}</span>
                                    </div>
                                </div>

                                <hr>

                                <!-- Bottom row -->
                                <div class="flex flex-row justify-evenly">
                                    <span>
                                        {{ computer.mac_address }}
                                    </span>
                                    <span>
                                        {{ computer.ip_address }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- Table -->
                        <table class="hidden md:table table-auto bg-white overflow-hidden shadow-xl sm:rounded-lg max-w-full divide-y-2 divide-gray-300 text-gray-900 text-left">
                            <thead>
                                <tr class="bg-indigo-400 text-xl font-bold divide-x">
                                    <th scope="col" class="px-6 py-4">Name</th>
                                    <th scope="col" class="px-6 py-4">Mac Address</th>
                                    <th scope="col" class="px-6 py-4">IP Address</th>
                                    <th scope="col" class="px-6 py-4">Wake-Up</th>
                                    <th scope="col" class="px-6 py-4">In use by</th>
                                    <th scope="col" class="px-6 py-4">Status</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-300">
                                <tr v-for="computer, computer_key in computers" :key="computer_key" class="border-box divide-x text-base font-light">
                                    <td class="px-6 py-4">{{ computer.name }}</td>
                                    <td class="px-6 py-4">{{ computer.mac_address }}</td>
                                    <td class="px-6 py-4">{{ computer.ip_address }}</td>
                                    <td class="px-6 py-4"><IndigoButton @click="wakeComputer(computer.id)">Wake-up</IndigoButton></td>
                                    <td class="px-6 py-4">
                                        <div class="flex flex-row justify-evenly items-center">
                                            <IndigoButton @click="useComputer(computer.id)">Use</IndigoButton>
                                            <span>{{ computer.users }}</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex flex-row justify-evenly">
                                            <span>{{ computer.status_updated_at }}</span>
                                            <StatusIndicator class="block m-auto" :type="computer.status">{{ computer.status }}</StatusIndicator>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

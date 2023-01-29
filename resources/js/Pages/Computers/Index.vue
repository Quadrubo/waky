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
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="grid grid-cols-1 m-auto">
                        <table class="table table-auto max-w-full divide-y-2 divide-gray-300 text-gray-900 text-left">
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
                                            <span>{{ computer.status_updated_at }} UTC</span>
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

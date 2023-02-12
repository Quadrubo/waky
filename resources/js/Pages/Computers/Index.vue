<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { router } from '@inertiajs/vue3';

import StatusIndicator from '@/Components/StatusIndicator.vue';
import IndigoButton from '@/Components/IndigoButton.vue';

let props = defineProps({
    computers: Object,
});

let wakeComputer = (id) => {
    router.post(route('computers.wake', id));
};

let shutdownComputer = (id) => {
    router.post(route('computers.shutdown', id));
};

let pingComputers = () => {
    router.post(route('computers.ping'));
};

let useComputer = (id) => {
    router.post(route('computers.use', id));
};

// Reload the users property on status update event
Echo.private(`computers`).listen('ComputerReachableStatusUpdated', (e) => {
    router.reload({
        preserveScroll: true,
        only: ['computers', 'flash'],
    });
});
</script>

<template>
    <AppLayout title="Computers">
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">Computers</h2>
            <IndigoButton @click="pingComputers">Refresh</IndigoButton>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="">
                    <div class="m-auto grid grid-cols-1">
                        <!-- Mobile Table -->
                        <div class="max-w-full space-y-4 px-2 md:hidden">
                            <div
                                v-for="(computer, computer_key) in computers"
                                :key="computer_key"
                                class="space-y-2 overflow-hidden rounded-md bg-white p-2 shadow-md"
                            >
                                <!-- {{ computer }} -->

                                <!-- Top row -->
                                <div class="flex flex-row items-center justify-between">
                                    <div class="flex flex-row items-center space-x-2">
                                        <StatusIndicator class="m-auto block" :type="computer.status">
                                            {{ computer.status }}
                                        </StatusIndicator>
                                        <span class="text-xl">
                                            {{ computer.name }}
                                        </span>
                                    </div>
                                    <div>
                                        <span> last updated {{ computer.status_updated_at }} </span>
                                    </div>
                                </div>

                                <hr />

                                <!-- Middle row -->
                                <div class="flex flex-row justify-evenly">
                                    <span>
                                        {{ computer.mac_address }}
                                    </span>
                                    <span>
                                        {{ computer.ip_address }}
                                    </span>
                                </div>

                                <hr />

                                <!-- Bottom row -->
                                <div class="flex flex-row items-center justify-between">
                                    <span>
                                        <IndigoButton @click="wakeComputer(computer.id)">Wake-up</IndigoButton>
                                    </span>
                                    <span>
                                        <IndigoButton @click="shutdownComputer(computer.id)">Shutdown</IndigoButton>
                                    </span>
                                    <div class="space-x-2">
                                        <IndigoButton @click="useComputer(computer.id)">Use</IndigoButton>
                                        <span>{{ computer.users }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Table -->
                        <table
                            class="hidden max-w-full table-auto divide-y-2 divide-gray-300 overflow-hidden bg-white text-left text-gray-900 shadow-xl sm:rounded-lg md:table"
                        >
                            <thead>
                                <tr class="divide-x bg-indigo-400 text-xl font-bold">
                                    <th scope="col" class="px-6 py-4">Name</th>
                                    <th scope="col" class="px-6 py-4">Mac Address</th>
                                    <th scope="col" class="px-6 py-4">IP Address</th>
                                    <th scope="col" class="px-6 py-4">Wake-Up</th>
                                    <th scope="col" class="px-6 py-4">Shutdown</th>
                                    <th scope="col" class="px-6 py-4">In use by</th>
                                    <th scope="col" class="px-6 py-4">Status</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-300">
                                <tr
                                    v-for="(computer, computer_key) in computers"
                                    :key="computer_key"
                                    class="border-box divide-x text-base font-light"
                                >
                                    <td class="px-6 py-4">
                                        {{ computer.name }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ computer.mac_address }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ computer.ip_address }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <IndigoButton @click="wakeComputer(computer.id)">Wake-up</IndigoButton>
                                    </td>
                                    <td class="px-6 py-4">
                                        <IndigoButton @click="shutdownComputer(computer.id)">Shutdown</IndigoButton>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex flex-row items-center justify-evenly">
                                            <IndigoButton @click="useComputer(computer.id)">Use</IndigoButton>
                                            <span>{{ computer.users }}</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex flex-row justify-evenly">
                                            <span>{{ computer.status_updated_at }}</span>
                                            <StatusIndicator class="m-auto block" :type="computer.status">{{
                                                computer.status
                                            }}</StatusIndicator>
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

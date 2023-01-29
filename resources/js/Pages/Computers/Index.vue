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
                    <!-- <table class="table table-auto max-w-full divide-y-2 divide-gray-300 shadow-xl rounded-lg overflow-hidden bg-white">
                            <thead>
                                <tr class="bg-yellow-500 divide-x divide-gray-300">
                                    <th scope="col" class="text-xl font-bold text-gray-900 px-6 py-4 text-left">Angebot</th>
                                    <th scope="col" class="text-xl font-bold text-gray-900 px-6 py-4 text-left">Preis</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-300">
                                <tr v-for="(price, key) in prices" :key="key" class="border-box divide-x divide-gray-300">
                                    <td class="text-base text-gray-900 font-light px-6 py-4">{{ price.title }}</td>
                                    <td v-if="price.request" class="text-base text-wrap text-blue-500 underline font-light px-6 py-4"><Link href="kontakt">{{ price.price }}</Link></td>
                                    <td v-else class="text-base text-wrap text-gray-900 font-light px-6 py-4">{{ price.price }}</td>
                                </tr>
                            </tbody>
                        </table> -->

                    <div class="grid grid-cols-1 m-auto">
                        <table class="table table-auto max-w-full divide-y-2 divide-gray-300 text-gray-900 text-left">
                            <thead>
                                <tr class="bg-indigo-400 text-xl font-bold divide-x">
                                    <th scope="col" class="px-6 py-4">ID</th>
                                    <th scope="col" class="px-6 py-4">Name</th>
                                    <th scope="col" class="px-6 py-4">Mac Address</th>
                                    <th scope="col" class="px-6 py-4">IP Address</th>
                                    <th scope="col" class="px-6 py-4">Wake-Up</th>
                                    <th scope="col" class="px-6 py-4">Status</th>
                                    <th scope="col" class="px-6 py-4">Status updated_at</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-300">
                                <tr v-for="computer, computer_key in computers" :key="computer_key" class="border-box divide-x text-base font-light">
                                    <td class="px-6 py-4">{{ computer.id }}</td>
                                    <td class="px-6 py-4">{{ computer.name }}</td>
                                    <td class="px-6 py-4">{{ computer.mac_address }}</td>
                                    <td class="px-6 py-4">{{ computer.ip_address }}</td>
                                    <td class="px-6 py-4"><IndigoButton @click="wakeComputer(computer.id)">Wake-up</IndigoButton></td>
                                    <td class="px-6 py-4"><StatusIndicator class="block m-auto" :type="computer.status">{{ computer.status }}</StatusIndicator></td>
                                    <td class="px-6 py-4">{{ computer.status_updated_at }} UTC</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </AppLayout>
</template>

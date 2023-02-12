<template>
    <transition
        appear
        enter-active-class="transform ease-out duration-300 transition"
        enter-from-class="translate-y-2 opacity-0 sm:translate-y-0 sm:translate-x-2"
        enter-to-class="translate-y-0 opacity-100 sm:translate-x-0"
        leave-active-class="transition ease-in duration-100"
        leave-from-class="opacity-100"
        leave-to-class="opacity-0"
    >
        <div
            v-show="notification && show"
            class="pointer-events-auto w-full max-w-sm overflow-hidden rounded-lg bg-white shadow-lg ring-1 ring-black ring-opacity-5"
            @mouseleave="show = false"
        >
            <div class="p-4">
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <MessageIcon :level="notification.level" />
                    </div>
                    <div class="ml-3 w-0 flex-1 pt-0.5">
                        <template v-if="notification.title && notification.message">
                            <p class="text-sm font-medium text-gray-900">
                                {{ notification.title }}
                            </p>
                            <p class="mt-1 text-sm text-gray-500">
                                {{ notification.message }}
                            </p>
                        </template>
                        <template v-else>
                            <p class="text-sm font-medium text-gray-900">
                                {{ notification.message || notification.title }}
                            </p>
                        </template>
                    </div>
                    <div class="ml-4 flex flex-shrink-0">
                        <button
                            class="inline-flex rounded-md bg-white text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                            @click="show = false"
                        >
                            <span class="sr-only">Close</span>
                            <CloseButton class="h-5 w-5" />
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </transition>
</template>

<script>
import MessageIcon from '@/Components/MessageIcon.vue';
import CloseButton from '@/Components/CloseButton.vue';

export default {
    components: { MessageIcon, CloseButton },

    props: {
        message: {
            type: Object,
            default: {},
        },
        timeout: {
            type: Number,
            default: 5,
        },
    },

    data() {
        return {
            show: true,
        };
    },

    computed: {
        notification() {
            return this.message;
        },
    },

    created() {
        setTimeout(() => (this.show = false), this.timeout * 1000);
    },
};
</script>

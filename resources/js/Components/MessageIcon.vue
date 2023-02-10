<template>
    <span v-if="level == 'info'">
        <svg
            :class="`text-${color}-400`"
            xmlns="http://www.w3.org/2000/svg"
            fill="none"
            viewBox="0 0 24 24"
            stroke-width="1.5"
            stroke="currentColor"
            class="h-6 w-6"
        >
            <path
                stroke-linecap="round"
                stroke-linejoin="round"
                d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z"
            />
        </svg>
    </span>

    <span v-else-if="level == 'success'">
        <svg
            :class="`text-${color}-400`"
            xmlns="http://www.w3.org/2000/svg"
            fill="none"
            viewBox="0 0 24 24"
            stroke-width="1.5"
            stroke="currentColor"
            class="h-6 w-6"
        >
            <path
                stroke-linecap="round"
                stroke-linejoin="round"
                d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
            />
        </svg>
    </span>

    <span v-else-if="level == 'warning'">
        <svg
            :class="`text-${color}-400`"
            xmlns="http://www.w3.org/2000/svg"
            fill="none"
            viewBox="0 0 24 24"
            stroke-width="1.5"
            stroke="currentColor"
            class="h-6 w-6"
        >
            <path
                stroke-linecap="round"
                stroke-linejoin="round"
                d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z"
            />
        </svg>
    </span>

    <span v-else-if="level == 'danger'">
        <svg
            :class="`text-${color}-400`"
            xmlns="http://www.w3.org/2000/svg"
            fill="none"
            viewBox="0 0 24 24"
            stroke-width="1.5"
            stroke="currentColor"
            class="h-6 w-6"
        >
            <path
                stroke-linecap="round"
                stroke-linejoin="round"
                d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z"
            />
        </svg>
    </span>
</template>

<script>
import { defineComponent } from 'vue';

export default defineComponent({
    props: {
        level: {
            type: String,
            default: 'error',
        },
    },
    computed: {
        color() {
            return {
                info: 'blue',
                success: 'green',
                warning: 'yellow',
                danger: 'red',
            }[this.level];
        },
    },
    // props: {
    //     type: {
    //         type: String,
    //         default: null
    //     },
    //     color: {
    //         type: String,
    //         default: 'blue'
    //     },
    //     text_color: {
    //         type: String,
    //         default: 'white'
    //     },
    //     strength: {
    //         type: Number,
    //         default: 0
    //     }
    // },
    // computed: {
    //     classes() {
    //         return `text-${this.text_color} bg-${this.color}-${500 + this.strength} hover:bg-${this.color}-${600 + this.strength} active:bg-${this.color}-${700 + this.strength}} focus:border-${this.color}-${700 + this.strength} focus:ring-${this.color}-${300 + this.strength}`;
    //     }
    // }
});
</script>

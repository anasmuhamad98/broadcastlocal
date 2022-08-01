<script setup>

import { DateTime } from "luxon";
</script>

<template>
    <td class="text-center px-6 py-4 text-md text-zinc-900">
        <!-- {{
            (date.getHours() < 10 ? "0" : "") +
            date.getHours() +
            ":" +
            (date.getMinutes() < 10 ? "0" : "") +
            date.getMinutes() +
            ":" +
            (date.getSeconds() < 10 ? "0" : "") +
            date.getSeconds() +
            "H"
        }} -->
        <!-- {{message.senddate}} -->
        {{DateTime.fromISO(this.message.created_at).toLocaleString(DateTime.TIME_24_WITH_SECONDS) + 'H'}}
    </td>
    <td class="text-center px-6 py-4 text-md text-zinc-900">
        {{ message.receiver }}
    </td>
    <td class="text-center px-6 py-4 text-md text-zinc-900">
        {{ message.sender }}
    </td>
    <td
        style="cursor: pointer"
        class="w-3/5 text-left px-6 py-4 text-md text-zinc-900 hover:bg-gray-200 rounded-md"
        v-on:click="$emit('clickmessage', message.message)"
    >
        {{ message.message.toUpperCase() }}
    </td>
    <td class="text-center px-6 py-4 text-md text-zinc-900">
        <button
            v-if="message.action == 'IX'"
            class="blink_me px-4 py-1 bg-yellow-500 rounded"
            v-on:click="$emit('clickIXbutton', message.id)"
            :disabled="message.user_id !==  $page.props.user.id "
        >
            {{ message.action }}
        </button>
        <button v-else :class="{ rixbutton: message.action === 'RIX' }">
            {{ message.action }}
        </button>
    </td>
</template>
<script>
export default {
    props: ["message"],
    emits: ["clickmessage" , 'clickIXbutton'],
    data: function () {
        return {
            date: DateTime.fromSQL(this.message.senddate).toLocaleString(DateTime.TIME_24_WITH_SECONDS),
            // date: new Date(this.message.created_at),
        };
    },
    methods: {

    },
    created(){
    }
};
</script>
<style>
.blink_me {
    animation: blinker 1s linear infinite;
}

.rixbutton {
    background-color: rgb(239 68 68);
    padding-left: 1rem;
    padding-right: 1rem;
    padding-top: 0.25rem;
    padding-bottom: 0.25rem;
    border-radius: 0.25rem;
    color: white;
}

@keyframes blinker {
    50% {
        opacity: 0;
    }
}
</style>

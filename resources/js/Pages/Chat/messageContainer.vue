<script setup>
import messageItem from "./messageItem.vue";
</script>

<template>
    <table class="divide-y divide-gray-300 border-y">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-2 text-md text-gray-500">TIME</th>
                <th class="px-6 py-2 text-md text-gray-500">TO</th>
                <th class="px-6 py-2 text-md text-gray-500">FROM</th>
                <th class="w-3/5 text-left px-6 py-2 text-md text-gray-500">
                    TEXT
                </th>
                <th class="px-6 py-2 text-md text-gray-500">ACTION</th>
            </tr>
            <tr>
                <th class="px-6 py-2 text-md text-gray-500">TIME</th>
                <th class="px-6 py-2 text-md text-gray-500">TO</th>
                <th class="px-6 py-2 text-md text-gray-500">FROM</th>
                <th class="w-3/5 text-left px-6 py-2 text-md text-gray-500">
                    TEXT
                </th>
                <th class="px-6 py-2 text-md text-gray-500">ACTION</th>
            </tr>
            <tr>
                <th class="px-6 py-2 text-md text-gray-500">TIME</th>
                <th class="px-6 py-2 text-md text-gray-500">TO</th>
                <th class="px-6 py-2 text-md text-gray-500">FROM</th>
                <th class="w-3/5 text-left px-6 py-2 text-md text-gray-500">
                    TEXT
                </th>
                <th class="px-6 py-2 text-md text-gray-500">ACTION</th>
            </tr>
            <tr>
                <th class="px-6 py-2 text-md text-gray-500">TIME</th>
                <th class="px-6 py-2 text-md text-gray-500">TO</th>
                <th class="px-6 py-2 text-md text-gray-500">FROM</th>
                <th class="w-3/5 text-left px-6 py-2 text-md text-gray-500">
                    TEXT
                </th>
                <th class="px-6 py-2 text-md text-gray-500">ACTION</th>
            </tr>
        </thead>
        <tbody class="flex flex-col-reverse">
            <tr
                class="border-b border-gray-300"
                v-for="(message, index) in messages"
                :key="index"
            >
                <message-item
                    :message="message"
                    v-on:clickmessage="$emit('clickmessage2', $event)"
                />
            </tr>
        </tbody>
    </table>
</template>

<script>
export default {
    components: { messageItem },
    props: ["messages"],
    emits: ["clickmessage2"],
    methods: {},
};
</script>

<style>
tbody {
    display: block;
    height: 500px;
    overflow: scroll;
}
thead,
tbody tr {
    display: table;
    width: 100%;
    table-layout: fixed;
}
</style>

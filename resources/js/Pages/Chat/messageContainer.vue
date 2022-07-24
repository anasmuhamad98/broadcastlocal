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
        </thead>
        <tbody style="max-height: 180px; height:auto; overflow:scroll">
            <tr class="border-b border-gray-300" v-for="(messagesIX, index) in messagesIXs"
                :key="index">
                <message-item
                    :message="messagesIX"
                    v-on:clickmessage="$emit('clickmessage2', $event)"
                    v-on:clickIXbutton="$emit('clickIXbutton2', $event)"
                />
            </tr>
        </tbody>
        <tbody class="flex flex-col-reverse bawah">
            <tr
                class="border-b border-gray-300"
                v-for="(message, index) in messages"
                :key="index"
                :class="{ fixedElement: message.action === '-IX' }"
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
    props: ["messages", 'messagesIXs'],
    emits: ["clickmessage2" , 'clickIXbutton2'],
    methods: {},
};
</script>

<style>
.fixedElement {
    background-color: #cad2fe;
    /* position:fixed; */
    /* top: 0; */
    width:100%;
    /* z-index:100; */
}
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

<template>
        <td class="text-center px-6 py-4 text-md text-zinc-900">{{ (date.getHours()<10?'0':'') + date.getHours()+ ":" + (date.getMinutes()<10?'0':'') + date.getMinutes()+ ":" + (date.getSeconds()<10?'0':'') + date.getSeconds() + "H"}}</td>
        <td class="text-center px-6 py-4 text-md text-zinc-900"></td>
        <td class="text-center px-6 py-4 text-md text-zinc-900">{{message.user.name}}</td>
        <td class="w-3/5 text-left px-6 py-4 text-md text-zinc-900" v-on:click="$emit('clickmessage', message.message)">{{message.message}}</td>
        <td class="text-center px-6 py-4 text-md text-zinc-900"><button>{{message.action}}</button></td>
</template>
<script>
export default{
    props: ['message'],
    emits:['clickmessage'],
    data: function () {
        return {
            date: new Date(this.message.created_at)
        };
    }
}
</script>

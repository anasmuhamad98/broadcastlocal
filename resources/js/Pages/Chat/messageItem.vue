<template>
        <td class="text-center px-6 py-4 text-md text-zinc-900">{{ (date.getHours()<10?'0':'') + date.getHours()+ ":" + (date.getMinutes()<10?'0':'') + date.getMinutes()+ ":" + (date.getSeconds()<10?'0':'') + date.getSeconds() + "H"}}</td>
        <td class="text-center px-6 py-4 text-md text-zinc-900">{{message.receiver}}</td>
        <td class="text-center px-6 py-4 text-md text-zinc-900">{{message.user.shortform}}</td>
        <td style="cursor:pointer" class="w-3/5 text-left px-6 py-4 text-md text-zinc-900 hover:bg-gray-200 rounded-md" v-on:click="$emit('clickmessage', message.message)">{{message.message.toUpperCase()}}</td>
        <td class="text-center px-6 py-4 text-md text-zinc-900"><button v-if="message.action == 'IX'" class="blink_me px-4 py-1 bg-yellow-500 rounded ">{{message.action}}</button>
        <button v-else>{{message.action}}</button></td>
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
<style>
.blink_me {
  animation: blinker 1s linear infinite;
}

@keyframes blinker {
  50% {
    opacity: 0;
  }
}
</style>

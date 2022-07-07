<template>
        <td class="text-center px-6 py-4 text-md text-zinc-900">{{ date.getHours() + ':' + date.getMinutes()}}</td>
        <td class="text-center px-6 py-4 text-md text-zinc-900"></td>
        <td class="text-center px-6 py-4 text-md text-zinc-900">{{message.user.name}}</td>
        <td class="w-2/3 text-left px-6 py-4 text-md text-zinc-900">{{message.message}}</td>
        <td class="text-center px-6 py-4 text-md text-zinc-900"><button>{{message.action}}</button></td>
</template>

<script>
export default{
    props: ['message'],
    data: function () {
        return {
            date: new Date(this.message.created_at)
        };
    },
}
</script>

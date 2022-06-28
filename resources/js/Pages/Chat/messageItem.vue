<template>
        <td class="text-center">{{message.created_at}}</td>
        <td class="text-center"></td>
        <td class="text-center">{{message.user.name}}</td>
        <td class="text-center">{{message.message}}</td>
        <td class="text-center"></td>
</template>

<script>
export default{
    props: ['message']
}
</script>

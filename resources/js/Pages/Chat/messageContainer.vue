<script setup>
import messageItem from "./messageItem.vue";
</script>

<template>
  <table>
    <thead>
      <tr>
        <th>TIME</th>
        <th>TO</th>
        <th>FROM</th>
        <th>TEXT</th>
        <th>ACTION</th>
      </tr>
    </thead>
    <tbody>
      <tr v-for="(message, index) in messages" :key="index">
        <message-item :message="message" />
      </tr>
    </tbody>
  </table>
  <!-- <div class="h-96 w-full">
    <div class="h-full p-2 flex flex-col-reverse overflow-scroll">
      <div v-for="(message, index) in messages" :key="index">
        <message-item :message="message" />
      </div>
    </div>
  </div> -->
</template>

<script>
export default {
  components: { messageItem },
  props: ["messages"],
  mounted() {
    this.scrollToElement();
  },
  mounted() {
    scrollToBottom();
  },
  methods: {
    scrollToBottom() {
      const container = this.$refs.container;
      container.scrollTop = container.scrollHeight;
    },
  },
};
</script>

<style>
tbody {
  display: block;
  height: 500px;
  overflow: auto;
}
thead,
tbody tr {
  display: table;
  width: 100%;
  table-layout: fixed;
}
</style>

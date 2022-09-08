<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import Welcome from "@/Jetstream/Welcome.vue";
import Auth from "./Auth/Auth";
</script>

<template>
  <!-- <AppLayout title="Dashboard"> -->
    <!-- <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Dashboard
      </h2>
    </template> -->

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
          <Welcome />
        </div>
      </div>
    </div>

    <button v-on:click="test" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition">Test</button>
  <!-- </AppLayout> -->
</template>
<script>
export default {
  data() {},
  mounted() {
    console.log(Auth);
  },
  methods: {
    test(){
        axios
                .get("http://taccomm.mafc2.mil.my/api/testlepaslogin")
                .then((response) => {
                    console.log(response.data)
                })
                .catch((error) => {
                    console.log(error);
                });
    }
  }
};
</script>


<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import Welcome from "@/Jetstream/Welcome.vue";
</script>

<template>
  <AppLayout title="Callsign">
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        CallSign
      </h2>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
          <div class="p-6 sm:px-20 bg-white border-b border-gray-200">
<table>
    <thead>
        <th>
Nama Kapal
        </th>
        <th>21 Rabu JUL 2022</th>
        <th>22 Rabu JUL 2022</th>
        <th>23 Rabu JUL 2022</th>
    </thead>
    <tbody>
        <tr v-for="(namakapal, index) in namakapals"
                                    :key="index">
            <td >
                                    {{namakapal.name}}
            </td>
        </tr>
    </tbody>
</table>
          </div>
        </div>
      </div>
    </div>
  </AppLayout>
</template>
<script>
export default {
    data() {
        return {
            namakapals: [],
        };
    },
    methods:{
        getKapal() {
            axios
                .get("/kapal/ajax")
                .then((response) => {
                    this.namakapals = response.data;
                })
                .catch((error) => {
                    console.log(error);
                });
        },
    },
    created(){
        this.getKapal();
    }
};
</script>

<style>
tbody {
    display: block;
}
thead,
tbody tr {
    display: table;
    width: 100%;
    table-layout: fixed;
}
</style>

<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import Welcome from "@/Jetstream/Welcome.vue";
</script>

<template>
    <AppLayout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Eksesais
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="card">
                        <div class="card-header text-center">
                            <div class="row">
                                <div class="card-body">
                                    <table class="table">
                                        <thead class="text-center">
                                            <tr>
                                                <th>SIRI</th>
                                                <th>SENARAI EKSESAIS</th>
                                            </tr>
                                        </thead>
                                        <tbody class="text-center">
                                            <tr
                                                id="clickable"
                                                onclick="window.location.href='/eksesais'"
                                            >
                                                <td>1</td>
                                                <td>PANGKOR WAR</td>
                                            </tr>
                                            <tr
                                                id="clickable"
                                                data-toggle="modal"
                                                data-target="#inbox"
                                            >
                                                <td>2</td>
                                                <td>EKSESAIS 2</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="row">
                                    <div class="col-md-1">
                                        <button
                                            type="button"
                                            class="btn btn-primary btn-circle btn-lg"
                                            data-toggle="modal"
                                            data-target="#tambaheksesais"
                                        >
                                            <img src="/images/plus.svg" />
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-body">
                <div
                    class="modal fade"
                    id="tambaheksesais"
                    tabindex="-1"
                    role="dialog"
                    aria-labelledby="tambaheksesaislabel"
                    aria-hidden="true"
                >
                    <div class="modal-dialog modal-xl" role="document">
                        <div class="modal-content">
                            <div
                                class="modal-header"
                                style="
                                    background: url(/images/bg3.jpeg) no-repeat;
                                    color: white;
                                "
                            >
                                <h5
                                    class="modal-title text-white"
                                    id="tambaheksesaislabel"
                                >
                                    Tambah Eksesais
                                </h5>
                                <button
                                    type="button"
                                    class="btn-close"
                                    data-dismiss="modal"
                                    aria-label="Close"
                                ></button>
                            </div>
                            <div class="modal-body"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
<script>
export default {};
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

<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import Welcome from "@/Jetstream/Welcome.vue";
import Button from "../../../vendor/laravel/jetstream/stubs/inertia/resources/js/Jetstream/Button.vue";
import Modal from "../../../vendor/laravel/jetstream/stubs/inertia/resources/js/Jetstream/Modal.vue";
import FormSection from "../../../vendor/laravel/jetstream/stubs/inertia/resources/js/Jetstream/FormSection.vue";
import Label from "../../../vendor/laravel/jetstream/stubs/inertia/resources/js/Jetstream/Label.vue";
import Input from "../../../vendor/laravel/jetstream/stubs/inertia/resources/js/Jetstream/Input.vue";
import DropdownLink from "../../../vendor/laravel/jetstream/stubs/inertia/resources/js/Jetstream/DropdownLink.vue";
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
                    <table>
                        <thead>
                            <tr>
                                <th>Siri</th>
                                <th>Nama Eksesais</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr
                                v-for="(
                                    senaraieksesais, index
                                ) in senaraieksesaises"
                                :key="index"
                            >
                                <td>{{ index + 1 }}</td>
                                <td>{{ senaraieksesais.Nama }}</td>
                                <td>
                                    <!-- <a v-bind:href="'/eksesais/'+ senaraieksesais.id"><Button>Lihat Chat</Button></a> -->
                                    <!-- <a class="nav-link" :href="route('home')">Home asdasdasd</a> -->
                                    <DropdownLink :href="route('eksesaischat', { id: senaraieksesais.id})">
                                                    Lihat chat
                                                </DropdownLink>
                                     <!-- <router-view></router-view> -->
                                    </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- Modal toggle -->
            <div>
                <button
                    class="bg-pink-500 text-white active:bg-pink-600 font-bold uppercase text-sm px-6 py-3 rounded shadow hover:shadow-lg outline-none focus:outline-none mr-1 mb-1 ease-linear transition-all duration-150"
                    type="button"
                    v-on:click="toggleModal()"
                >
                    Open large modal
                </button>
                <div
                    v-if="showModal"
                    class="overflow-x-hidden overflow-y-auto fixed inset-0 z-50 outline-none focus:outline-none justify-center items-center flex"
                >
                    <div class="relative w-auto my-6 mx-auto max-w-6xl">
                        <!--content-->
                        <div
                            class="border-0 rounded-lg shadow-lg relative flex flex-col w-full bg-white outline-none focus:outline-none"
                        >
                            <!--header-->
                            <div
                                class="flex items-start justify-between p-5 border-b border-solid border-slate-200 rounded-t"
                            >
                                <h3 class="text-3xl font-semibold">
                                    Modal Title
                                </h3>
                                <button
                                    class="p-1 ml-auto bg-transparent border-0 text-black opacity-5 float-right text-3xl leading-none font-semibold outline-none focus:outline-none"
                                    v-on:click="toggleModal()"
                                >
                                    <span
                                        class="bg-transparent text-black opacity-5 h-6 w-6 text-2xl block outline-none focus:outline-none"
                                    >
                                        ×
                                    </span>
                                </button>
                            </div>
                            <!--body-->
                            <div class="relative p-6 flex-auto">
                                <Label
                                    for="email"
                                    value="Nama Eksesais"
                                    class="my-4 text-slate-500 text-lg leading-relaxed"
                                />
                                <input
                                    type="text"
                                    v-model="namaEksesais"
                                    class="px-3 py-3 placeholder-slate-300 text-slate-600 relative bg-white bg-white rounded text-sm border-0 shadow outline-none focus:outline-none focus:ring w-full"
                                />

                                <Label
                                    for="email"
                                    value="Senarai Kapal"
                                    class="my-4 text-slate-500 text-lg leading-relaxed"
                                />
                                <div
                                    v-for="(namakapal, index) in namakapals"
                                    :key="index"
                                >
                                    <label class="text-gray-700">
                                        <input
                                            type="checkbox"
                                            v-model="senaraiKapalTerlibat"
                                            :value="namakapal.id"
                                        />
                                        <span class="ml-1">{{
                                            namakapal.name
                                        }}</span>
                                    </label>
                                </div>
                            </div>
                            <!--footer-->
                            <div
                                class="flex items-center justify-end p-6 border-t border-solid border-slate-200 rounded-b"
                            >
                                <button
                                    class="text-red-500 bg-transparent border border-solid border-red-500 hover:bg-red-500 hover:text-white active:bg-red-600 font-bold uppercase text-sm px-6 py-3 rounded outline-none focus:outline-none mr-1 mb-1 ease-linear transition-all duration-150"
                                    type="button"
                                    v-on:click="toggleModal()"
                                >
                                    Close
                                </button>
                                <button
                                    class="text-red-500 background-transparent font-bold uppercase px-6 py-2 text-sm outline-none focus:outline-none mr-1 mb-1 ease-linear transition-all duration-150"
                                    type="button"
                                    @click="saveEksesais()"
                                >
                                    Create Eksesais
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div
                    v-if="showModal"
                    class="opacity-25 fixed inset-0 z-40 bg-black"
                ></div>
            </div>
        </div>
    </AppLayout>
</template>
<script>
export default {
    components: {
        Label,
        Input,
    },
    data() {
        return {
            showModal: false,
            namakapals: [],
            namaEksesais: "",
            senaraiKapalTerlibat: [],
            senaraieksesaises: [],
        };
    },
    methods: {
        toggleModal: function () {
            this.showModal = !this.showModal;
        },

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

        saveEksesais() {
            if (this.namaEksesais == "") {
                return;
            }
            axios
                .post("/eksesaisdata", {
                    namaEksesais: this.namaEksesais,
                    senaraiKapalTerlibat: this.senaraiKapalTerlibat,
                })
                .then((response) => {
                    if (response.status == 200) {
                        console.log("Jadi");
                        this.namaEksesais = "";
                        this.senaraiKapalTerlibat = [];
                        this.getEksesais();
                        this.showModal = !this.showModal;
                    }
                })
                .catch((error) => {
                    console.log("x Jadi");
                    console.log(error);
                });
        },

        getEksesais() {
            axios
                .get("/eksesaisdata")
                .then((response) => {
                    this.senaraieksesaises = response.data;
                })
                .catch((error) => {
                    console.log(error);
                });
        },
    },
    created() {
        this.getKapal();
        this.getEksesais();
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
tbody tr td {
    text-align: center;
}
</style>

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
        <div class="container flex justify-center mx-auto my-20">
            <div class="flex justify-center">
                <div class="w-2/3 relative">
                    <div class="border-b border-gray-200 shadow">
                        <table class="divide-y divide-gray-300 border-y">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-2 text-md text-gray-500">
                                        Siri
                                    </th>
                                    <th class="px-6 py-2 text-md text-gray-500">
                                        Nama Eksesais
                                    </th>
                                    <th class="px-6 py-2 text-md text-gray-500">
                                        Tindakan
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-300">
                                <tr
                                    class="whitespace-nowrap"
                                    v-for="(
                                        senaraieksesais, index
                                    ) in senaraieksesaises"
                                    :key="index"
                                >
                                    <td class="px-6 py-4 text-lg text-gray-500">
                                        {{ index + 1 }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-lg text-gray-900">
                                            {{ senaraieksesais.Nama }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <!-- <a v-bind:href="'/eksesais/'+ senaraieksesais.id"><Button>Lihat Chat</Button></a> -->
                                        <!-- <a class="nav-link" :href="route('home')">Home asdasdasd</a> -->
                                        <div class="flex justify-center">
                                            <DropdownLink
                                                class="bg-gray-200 rounded"
                                                :href="
                                                    route('eksesaischat', {
                                                        id: senaraieksesais.id,
                                                    })
                                                "
                                            >
                                                Lihat chat
                                            </DropdownLink>
                                            <!-- <router-view></router-view> -->
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="absolute right-0 bottom-0">
                        <button
                            class="bg-gray-500 text-white active:bg-gray-600 font-bold uppercase text-sm px-6 py-3 rounded shadow hover:shadow-lg outline-none focus:outline-none mr-1 mb-1 ease-linear transition-all duration-150"
                            type="button"
                            v-on:click="toggleModal()"
                        >
                            Tambah Eksesais
                        </button>
                    </div>
                </div>

                <!-- Modal toggle -->
                <div>
                    <div
                        v-if="showModal"
                        class="overflow-x-hidden overflow-y-auto fixed inset-0 z-50 outline-none focus:outline-none justify-center items-center"
                    >
                        <div class="relative my-6 mx-auto max-w-6xl">
                            <!--content-->
                            <div
                                class="border-0 rounded-lg shadow-lg relative flex flex-col w-full bg-white outline-none focus:outline-none"
                            >
                                <!--header-->
                                <div
                                    class="flex items-start justify-between p-5 border-b border-solid border-slate-200 rounded-t"
                                >
                                    <h3 class="text-xl font-semibold">
                                        Tambah Eksesais
                                    </h3>
                                    <button
                                        class="ml-auto bg-transparent border-0 text-black opacity-70 float-right text-3xl leading-none font-semibold outline-none focus:outline-none"
                                        v-on:click="toggleModal()"
                                    >
                                        <span
                                            class="bg-transparent text-black opacity-70 h-6 w-6 text-2xl block outline-none focus:outline-none"
                                        >
                                            ×
                                        </span>
                                    </button>
                                </div>
                                <!--body-->
                                <div class="relative px-6 pb-3 flex-auto">
                                    <Label
                                        value="Nama Eksesais"
                                        class="my-4 text-slate-500 text-lg leading-relaxed"
                                    />
                                    <input
                                        type="text"
                                        v-model="namaEksesais"
                                        class="px-3 py-3 placeholder-slate-300 text-slate-600 relative bg-white rounded text-sm shadow border-current focus:outline-none focus:ring w-full"
                                    />
                                    <Label
                                        value="Callsign"
                                        class="my-4 text-slate-500 text-lg leading-relaxed"
                                    />
                                    <div
                                        v-for="index in numberofcallsign"
                                        :key="index"
                                    >
                                        <input
                                            type="text"
                                            placeholder="CTO"
                                            v-model="callsignforeksesais[index]"
                                            class="px-3 py-3 placeholder-slate-300 text-slate-600 relative bg-white rounded text-sm shadow border-current focus:outline-none focus:ring w-2/5"
                                        />
                                        <input
                                            type="text"
                                            placeholder="A1"
                                            v-model="
                                                callsign2foreksesais[index]
                                            "
                                            class="px-3 py-3 placeholder-slate-300 text-slate-600 relative bg-white rounded text-sm shadow border-current focus:outline-none focus:ring w-2/5"
                                        />
                                    </div>
                                    <button
                                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded"
                                        @click="addnumberofcallsign()"
                                    >
                                        add callsign
                                    </button>

                                    <button
                                        v-if="numberofcallsign !== 0"
                                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded"
                                        @click="removenumberofcallsign()"
                                    >
                                        remove callsign
                                    </button>
                                    <Label
                                        for="email"
                                        value="Senarai Kapal"
                                        class="my-4 text-slate-500 text-lg leading-relaxed"
                                    />
                                    <div class="flex flex-row flex-wrap">
                                        <div
                                            class="form-check w-1/3"
                                            v-for="(
                                                namakapal, index
                                            ) in namakapals"
                                            :key="index"
                                        >
                                            <label class="text-gray-700">
                                                <input
                                                    class="form-check-input"
                                                    type="checkbox"
                                                    v-model="
                                                        senaraiKapalTerlibat
                                                    "
                                                    :value="namakapal.id"
                                                />
                                                <span class="ml-1">{{
                                                    namakapal.name
                                                }}</span>
                                                &nbsp;
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <!--footer-->
                                <div
                                    class="flex items-center justify-end p-6 border-t border-solid border-slate-200 rounded-b"
                                >
                                    <button
                                        class="text-red-500 background-transparent font-bold uppercase px-6 py-2 text-sm outline-none focus:outline-none mr-1 mb-1 ease-linear transition-all duration-150"
                                        type="button"
                                        @click="saveEksesais()"
                                    >
                                        Tambah Eksesais
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
            numberofcallsign: 0,
            callsignforeksesais: [],
            callsign2foreksesais: [],
        };
    },
    mounted() {
        window.Echo.private("eksesais").listen("NewEksesais", (e) => {
            this.getEksesais();
        });
    },
    unmounted() {
        window.Echo.leave("eksesais");
    },
    methods: {
        removenumberofcallsign() {
            this.numberofcallsign--;
        },
        addnumberofcallsign() {
            console.log(this.callsignforeksesais);
            this.numberofcallsign++;
        },

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
                    callsign1: this.callsignforeksesais,
                    callsign2: this.callsign2foreksesais,
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

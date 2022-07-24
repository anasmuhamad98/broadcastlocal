<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import Welcome from "@/Jetstream/Welcome.vue";
import moment from "moment";
import Label from "../../../vendor/laravel/jetstream/stubs/inertia/resources/js/Jetstream/Label.vue";
</script>

<template>
    <AppLayout title="Callsign">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                CallSign
            </h2>
        </template>
        <button
            class="bg-gray-500 text-white active:bg-gray-600 font-bold uppercase text-sm px-6 py-3 rounded shadow hover:shadow-lg outline-none focus:outline-none mr-1 mb-1 ease-linear transition-all duration-150"
            type="button"
            v-on:click="toggleModal()"
        >
            Tambah Eksesais
        </button>
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
                                Assign callsign
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
                            <label for="">Tarikh : </label>
                            <!-- <input type="date"  v-model="getdate"> -->
                            <select name="" id="" v-model="getdate">
                                <option :value="moment().format('D')">
                                    {{ moment().format("dddd Do MMM YYYY") }}
                                </option>
                                <option
                                    :value="moment().add(1, 'days').format('D')"
                                >
                                    {{
                                        moment()
                                            .add(1, "days")
                                            .format("dddd Do MMM YYYY")
                                    }}
                                </option>
                                <option
                                    :value="moment().add(2, 'days').format('D')"
                                >
                                    {{
                                        moment()
                                            .add(2, "days")
                                            .format("dddd Do MMM YYYY")
                                    }}
                                </option>
                            </select>
                            <Label
                                for="email"
                                value="Senarai Kapal"
                                class="my-4 text-slate-500 text-lg leading-relaxed"
                            />
                            <div class="flex flex-row flex-wrap">
                                <div
                                    class="form-check w-1/6"
                                    v-for="(namakapal, index) in namakapals"
                                    :key="index"
                                >
                                    <div class="row mb-1">
                                        <div class="col-lg-6">
                                            <label class="text-gray-700">
                                                <span class="mx-1"
                                                    ><strong>{{
                                                        namakapal.shortform
                                                    }}</strong></span
                                                >
                                            </label>
                                        </div>
                                        <div class="col-lg-2">
                                            <input
                                                type="text"
                                                name=""
                                                id=""
                                                hidden
                                                v-model="idKapal[index]"
                                            />
                                            <input
                                                class="shadow appearance-none border rounded w-20 py-2 px-3 text-gray-900 leading-tight focus:outline-none focus:shadow-outline"
                                                type="text"
                                                v-model="callsignkapal[index]"
                                            />
                                            &nbsp;
                                        </div>
                                    </div>
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
                                @click="getcallsign()"
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
        <div class="py-4">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="p-6 sm:px-20 bg-white border-b border-gray-200">
                        <table class="border border-gray-900">
                            <thead class="border border-gray-900">
                                <th>Nama Kapal</th>
                                <th>
                                    {{ moment().format("D MMM") }}
                                </th>
                                <th>
                                    {{
                                        moment().add(1, "days").format("D MMM")
                                    }}
                                </th>
                                <th>
                                    {{
                                        moment().add(2, "days").format("D MMM")
                                    }}
                                </th>
                                <th>
                                    {{
                                        moment().add(3, "days").format("D MMM")
                                    }}
                                </th>
                                <th>
                                    {{
                                        moment().add(4, "days").format("D MMM")
                                    }}
                                </th>
                            </thead>
                            <tbody>
                                <tr
                                    v-for="(namakapal, index) in namakapals"
                                    :key="index"
                                    class="text-center"
                                >
                                    <td>
                                        {{ namakapal.shortform }}
                                    </td>
                                    <td
                                        v-if="
                                            namakapal.callsigns.find(
                                                (element) =>
                                                    element.tarikhhari ===
                                                    moment().format('D')
                                            )
                                        "
                                    >
                                        {{
                                            namakapal.callsigns.find(
                                                (element) =>
                                                    element.tarikhhari ===
                                                    moment().format("D")
                                            ).callsign
                                        }}
                                    </td>
                                    <td v-else></td>
                                    <td
                                        v-if="
                                            namakapal.callsigns.find(
                                                (element) =>
                                                    element.tarikhhari ===
                                                    moment()
                                                        .add(1, 'days')
                                                        .format('D')
                                            )
                                        "
                                    >
                                        {{
                                            namakapal.callsigns.find(
                                                (element) =>
                                                    element.tarikhhari ===
                                                    moment()
                                                        .add(1, "days")
                                                        .format("D")
                                            ).callsign
                                        }}
                                    </td>
                                    <td v-else></td>
                                    <td
                                        v-if="
                                            namakapal.callsigns.find(
                                                (element) =>
                                                    element.tarikhhari ===
                                                    moment()
                                                        .add(2, 'days')
                                                        .format('D')
                                            )
                                        "
                                    >
                                        {{
                                            namakapal.callsigns.find(
                                                (element) =>
                                                    element.tarikhhari ===
                                                    moment()
                                                        .add(2, "days")
                                                        .format("D")
                                            ).callsign
                                        }}
                                    </td>
                                    <td v-else></td>
                                    <td
                                        v-if="
                                            namakapal.callsigns.find(
                                                (element) =>
                                                    element.tarikhhari ===
                                                    moment()
                                                        .add(3, 'days')
                                                        .format('D')
                                            )
                                        "
                                    >
                                        {{
                                            namakapal.callsigns.find(
                                                (element) =>
                                                    element.tarikhhari ===
                                                    moment()
                                                        .add(3, "days")
                                                        .format("D")
                                            ).callsign
                                        }}
                                    </td>
                                    <td v-else></td>
                                    <td
                                        v-if="
                                            namakapal.callsigns.find(
                                                (element) =>
                                                    element.tarikhhari ===
                                                    moment()
                                                        .add(4, 'days')
                                                        .format('D')
                                            )
                                        "
                                    >
                                        {{
                                            namakapal.callsigns.find(
                                                (element) =>
                                                    element.tarikhhari ===
                                                    moment()
                                                        .add(4, "days")
                                                        .format("D")
                                            ).callsign
                                        }}
                                    </td>
                                    <td v-else></td>
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
    components: {
        moment
    },
    data() {
        return {
            showModal: false,
            namakapals: [],
            callsignkapal: [],
            currentDate: moment(),
            getdate: "",
            idKapal: [],
            options: ["foo", "bar", "baz"],
        };
    },
    methods: {
        toggleModal: function () {
            this.showModal = !this.showModal;
        },
        getKapal() {
            axios
                .get("/kapal/callsign")
                .then((response) => {
                    this.namakapals = response.data;
                    this.namakapals.forEach((namakapal) => {
                        if (!this.idKapal.includes(namakapal.id)) {
                            this.idKapal.push(namakapal.id);
                        }
                    });
                })
                .catch((error) => {
                    console.log(error);
                });
        },
        getcallsign() {
            console.log(this.getdate);
            axios
                .post("/saveallcallsign", {
                    idKapal: this.idKapal,
                    callsignkapal: this.callsignkapal,
                    tarikhhari: this.getdate,
                })
                .then((response) => {
                    if (response.status == 200) {
                        console.log(response.data);
                        this.showModal = !this.showModal;
                    }
                })
                .catch((error) => {
                    console.log(error);
                });
        },
    },
    created() {
        this.getKapal();
    },
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
    /* border: 1px solid gray; */
}

tbody td,
th {
    border: 1px solid gray;
}
</style>

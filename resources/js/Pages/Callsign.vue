<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import Welcome from "@/Jetstream/Welcome.vue";
import moment from "moment";
import Label from "../../../vendor/laravel/jetstream/stubs/inertia/resources/js/Jetstream/Label.vue";

import { DateTime } from "luxon";
</script>

<template>
    <AppLayout title="Callsign">
        <template #header>
            <h2
                class="font-semibold text-xl text-gray-800 leading-tight relative"
            >
                CallSign
                <button
                    class="absolute right-0 bg-gray-500 text-white active:bg-gray-600 font-bold uppercase text-sm px-6 py-3 rounded shadow hover:shadow-lg outline-none focus:outline-none mr-1 mb-1 ease-linear transition-all duration-150"
                    type="button"
                    v-on:click="toggleModal()"
                >
                    Kemaskini Callsign
                </button>
            </h2>
        </template>
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
                            class="flex items-start justify-between p-5 border border-solid border-slate-200 rounded-t"
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
                            <input type="date" v-model="getdate" />

                            <Label
                                value="Panggilan Taktikal"
                                class="my-4 text-slate-500 text-lg leading-relaxed"
                            />
                            <div
                                v-for="index in numberofcallsign"
                                :key="index"
                                class="mb-2"
                            >
                                <input
                                    type="text"
                                    placeholder="CTO"
                                    v-model="callsignforeksesais[index]"
                                    class="mr-6 px-3 py-3 placeholder-slate-300 text-slate-600 relative bg-white rounded text-sm shadow border-current focus:outline-none focus:ring w-2/5"
                                />
                                <input
                                    type="text"
                                    placeholder="A1"
                                    v-model="callsign2foreksesais[index]"
                                    class="px-3 py-3 placeholder-slate-300 text-slate-600 relative bg-white rounded text-sm shadow border-current focus:outline-none focus:ring w-1/12"
                                />
                            </div>
                            <button
                                class="mr-2 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded"
                                @click="addnumberofcallsign()"
                            >
                                Tambah Callsign
                            </button>

                            <button
                                v-if="numberofcallsign !== 0"
                                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded"
                                @click="removenumberofcallsign()"
                            >
                                Padam Callsign
                            </button>
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
                                @click="savecallsign()"
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
            <div class="mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="p-6 sm:px-20 bg-white border border-gray-200">
                        <!-- get callsign of eksesais -->
                        <table class="border border-gray-500 w-full">
                            <thead class="border border-gray-500">
                                <th
                                    class="px-6 py-2 text-md text-gray-500 border border-gray-500"
                                >
                                    Unit
                                </th>
                                <th class="px-6 py-2 text-md text-gray-500">
                                    {{ datenow.toFormat("d MMM") }}
                                </th>
                                <th
                                    class="px-6 py-2 text-md text-gray-500 border border-gray-500"
                                >
                                    {{
                                        datenow
                                            .plus({ days: 1 })
                                            .toFormat("d MMM")
                                    }}
                                </th>
                                <th
                                    class="px-6 py-2 text-md text-gray-500 border border-gray-500"
                                >
                                    {{
                                        datenow
                                            .plus({ days: 2 })
                                            .toFormat("d MMM")
                                    }}
                                </th>
                                <th
                                    class="px-6 py-2 text-md text-gray-500 border border-gray-500"
                                >
                                    {{
                                        datenow
                                            .plus({ days: 3 })
                                            .toFormat("d MMM")
                                    }}
                                </th>
                                <th
                                    class="px-6 py-2 text-md text-gray-500 border border-gray-500"
                                >
                                    {{
                                        datenow
                                            .plus({ days: 4 })
                                            .toFormat("d MMM")
                                    }}
                                </th>
                            </thead>
                            <tbody class="border border-gray-500">
                                <tr
                                    v-for="(unit, index) in callsignunit"
                                    :key="index"
                                    class="text-center border border-gray-500"
                                >
                                    <td>
                                        {{ unit.callsign1 }}
                                    </td>
                                    <td class="border border-gray-500">
                                        <span
                                            v-if="
                                                callsigneksesais.find(
                                                    (element) =>
                                                        element.tarikh ===
                                                            datenow.toSQLDate() &&
                                                        element.callsign1 ===
                                                            unit.callsign1
                                                )
                                            "
                                            >{{
                                                callsigneksesais.find(
                                                    (element) =>
                                                        element.tarikh ===
                                                            datenow.toSQLDate() &&
                                                        element.callsign1 ===
                                                            unit.callsign1
                                                ).callsign2
                                            }}</span
                                        >
                                    </td>
                                    <td class="border border-gray-500">
                                        <span
                                            v-if="
                                                callsigneksesais.find(
                                                    (element) =>
                                                        element.tarikh ===
                                                            datenow
                                            .plus({ days: 1 }).toSQLDate() &&
                                                        element.callsign1 ===
                                                            unit.callsign1
                                                )
                                            "
                                            >{{
                                                callsigneksesais.find(
                                                    (element) =>
                                                        element.tarikh ===
                                                            datenow
                                            .plus({ days: 1 }).toSQLDate() &&
                                                        element.callsign1 ===
                                                            unit.callsign1
                                                ).callsign2
                                            }}</span
                                        >
                                    </td>
                                    <td class="border border-gray-500">
                                        <span
                                            v-if="
                                                callsigneksesais.find(
                                                    (element) =>
                                                        element.tarikh ===
                                                            datenow
                                            .plus({ days: 2 }).toSQLDate() &&
                                                        element.callsign1 ===
                                                            unit.callsign1
                                                )
                                            "
                                            >{{
                                                callsigneksesais.find(
                                                    (element) =>
                                                        element.tarikh ===
                                                            datenow
                                            .plus({ days: 2 }).toSQLDate() &&
                                                        element.callsign1 ===
                                                            unit.callsign1
                                                ).callsign2
                                            }}</span
                                        >
                                    </td>
                                    <td class="border border-gray-500">
                                        <span
                                            v-if="
                                                callsigneksesais.find(
                                                    (element) =>
                                                        element.tarikh ===
                                                            datenow
                                            .plus({ days: 3 }).toSQLDate() &&
                                                        element.callsign1 ===
                                                            unit.callsign1
                                                )
                                            "
                                            >{{
                                                callsigneksesais.find(
                                                    (element) =>
                                                        element.tarikh ===
                                                            datenow
                                            .plus({ days: 3 }).toSQLDate() &&
                                                        element.callsign1 ===
                                                            unit.callsign1
                                                ).callsign2
                                            }}</span
                                        >
                                    </td>
                                    <td class="border border-gray-500">
                                        <span
                                            v-if="
                                                callsigneksesais.find(
                                                    (element) =>
                                                        element.tarikh ===
                                                            datenow
                                            .plus({ days: 4 }).toSQLDate() &&
                                                        element.callsign1 ===
                                                            unit.callsign1
                                                )
                                            "
                                            >{{
                                                callsigneksesais.find(
                                                    (element) =>
                                                        element.tarikh ===
                                                            datenow
                                            .plus({ days: 4 }).toSQLDate() &&
                                                        element.callsign1 ===
                                                            unit.callsign1
                                                ).callsign2
                                            }}</span
                                        >
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <br />
                        <!-- get callsign of kapal -->
                        <table class="border border-gray-500 w-full">
                            <thead class="border border-gray-500">
                                <th
                                    class="px-6 py-2 text-md text-gray-500 border border-gray-500"
                                >
                                    Nama Kapal
                                </th>
                                <th class="px-6 py-2 text-md text-gray-500">
                                    {{ moment().format("D MMM") }}
                                </th>
                                <th
                                    class="px-6 py-2 text-md text-gray-500 border border-gray-500"
                                >
                                    {{
                                        moment().add(1, "days").format("D MMM")
                                    }}
                                </th>
                                <th
                                    class="px-6 py-2 text-md text-gray-500 border border-gray-500"
                                >
                                    {{
                                        moment().add(2, "days").format("D MMM")
                                    }}
                                </th>
                                <th
                                    class="px-6 py-2 text-md text-gray-500 border border-gray-500"
                                >
                                    {{
                                        moment().add(3, "days").format("D MMM")
                                    }}
                                </th>
                                <th
                                    class="px-6 py-2 text-md text-gray-500 border border-gray-500"
                                >
                                    {{
                                        moment().add(4, "days").format("D MMM")
                                    }}
                                </th>
                            </thead>
                            <tbody class="border border-gray-500">
                                <tr
                                    v-for="(namakapal, index) in namakapals"
                                    :key="index"
                                    class="text-center border border-gray-500"
                                >
                                    <td>
                                        {{ namakapal.shortform }}
                                    </td>
                                    <td
                                        class="border border-gray-500"
                                        v-if="
                                            namakapal.callsigns.find(
                                                (element) =>
                                                    element.tarikh ===
                                                    datenow.toSQLDate()
                                            )
                                        "
                                    >
                                        {{
                                            namakapal.callsigns.find(
                                                (element) =>
                                                    element.tarikh ===
                                                    datenow.toSQLDate()
                                            ).callsign
                                        }}
                                    </td>
                                    <td
                                        v-else
                                        class="border border-gray-500"
                                    ></td>
                                    <td
                                        class="border border-gray-500"
                                        v-if="
                                            namakapal.callsigns.find(
                                                (element) =>
                                                    element.tarikh ===
                                                    datenow
                                            .plus({ days: 1 }).toSQLDate()
                                            )
                                        "
                                    >
                                        {{
                                            namakapal.callsigns.find(
                                                (element) =>
                                                    element.tarikh ===
                                                    datenow
                                            .plus({ days: 1 }).toSQLDate()
                                            ).callsign
                                        }}
                                    </td>
                                    <td
                                        v-else
                                        class="border border-gray-500"
                                    ></td>
                                    <td
                                        class="border border-gray-500"
                                        v-if="
                                            namakapal.callsigns.find(
                                                (element) =>
                                                    element.tarikh ===
                                                    datenow
                                            .plus({ days: 2 }).toSQLDate()
                                            )
                                        "
                                    >
                                        {{
                                            namakapal.callsigns.find(
                                                (element) =>
                                                    element.tarikh ===
                                                    datenow
                                            .plus({ days: 2 }).toSQLDate()
                                            ).callsign
                                        }}
                                    </td>
                                    <td
                                        v-else
                                        class="border border-gray-500"
                                    ></td>
                                    <td
                                        class="border border-gray-500"
                                        v-if="
                                            namakapal.callsigns.find(
                                                (element) =>
                                                    element.tarikh ===
                                                    datenow
                                            .plus({ days: 3 }).toSQLDate()
                                            )
                                        "
                                    >
                                        {{
                                            namakapal.callsigns.find(
                                                (element) =>
                                                    element.tarikh ===
                                                    datenow
                                            .plus({ days: 3 }).toSQLDate()
                                            ).callsign
                                        }}
                                    </td>
                                    <td
                                        v-else
                                        class="border border-gray-500"
                                    ></td>
                                    <td
                                        class="border border-gray-500"
                                        v-if="
                                            namakapal.callsigns.find(
                                                (element) =>
                                                    element.tarikh ===
                                                    datenow
                                            .plus({ days: 4 }).toSQLDate()
                                            )
                                        "
                                    >
                                        {{
                                            namakapal.callsigns.find(
                                                (element) =>
                                                    element.tarikh ===
                                                    datenow
                                            .plus({ days: 4 }).toSQLDate()
                                            ).callsign
                                        }}
                                    </td>
                                    <td
                                        v-else
                                        class="border border-gray-500"
                                    ></td>
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
        moment,
    },
    data() {
        return {
            showModal: false,
            namakapals: [],
            callsignkapal: [],
            currentDate: moment(),
            getdate: "",
            idKapal: [],
            numberofcallsign: 0,
            callsignforeksesais: [],
            callsign2foreksesais: [],
            callsigneksesais: [],
            callsignunit: [],
            datenow: DateTime.now(),
        };
    },
    methods: {
        toggleModal: function () {
            this.showModal = !this.showModal;
        },
        removenumberofcallsign() {
            this.numberofcallsign--;
        },
        addnumberofcallsign() {
            this.numberofcallsign++;
        },
        getcallsigneksesais() {
            axios
                .get("/callsign/eksesais")
                .then((response) => {
                    this.callsigneksesais = response.data.callsigneksesais;
                    this.callsignunit = response.data.callsigngroup;
                    console.log(
                        "callsign untuk eksesais",
                        this.callsigneksesais
                    );
                })
                .catch((error) => {
                    console.log(error);
                });
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
        savecallsign() {
            console.log(this.getdate);
            axios
                .post("/saveallcallsign", {
                    idKapal: this.idKapal,
                    callsignkapal: this.callsignkapal,
                    tarikhhari: this.getdate,
                    callsign1: this.callsignforeksesais,
                    callsign2: this.callsign2foreksesais,
                })
                .then((response) => {
                    if (response.status == 200) {
                        console.log("dapatkan semua callsign", response.data);
                        this.getKapal();
                        this.showModal = !this.showModal;
                    }
                })
                .catch((error) => {
                    console.log(error);
                });
        },
    },
    created() {
        this.getcallsigneksesais();
        this.getKapal();
        console.log(this.datenow);
    },
};
</script>

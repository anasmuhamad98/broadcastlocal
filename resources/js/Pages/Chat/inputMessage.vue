<script setup>
import Input from "../../Jetstream/Input.vue";
import SecondaryButton from "../../../../vendor/laravel/jetstream/stubs/inertia/resources/js/Jetstream/SecondaryButton.vue";
</script>

<template>
    <div class="relative m-1">
        <div v-if="quickguide === false" style="border-top: 1px solid #e6e6e6">
            <select
                v-model="sendercallsign"
                class="mr-1 shadow appearance-none border rounded w-auto py-2 px-3 text-gray-900 leading-tight focus:outline-none focus:shadow-outline"
            >
                <option value="">From</option>
                <option
                    v-for="(callsign, index) in callsigneksesais"
                    :key="index"
                    :value="callsign.callsign2"
                >
                    {{ callsign.callsign1 + "-" + callsign.callsign2 }}
                </option>
            </select>
            <input
                type="text"
                v-model="message"
                placeholder="Groupers..."
                class="shadow appearance-none border rounded w-4/5 py-2 px-3 text-gray-900 leading-tight focus:outline-none focus:shadow-outline"
            />
            <select
                v-model="idkapalindividual"
                class="ml-1 shadow appearance-none border rounded w-auto py-2 px-3 text-gray-900 leading-tight focus:outline-none focus:shadow-outline"
            >
                <option value="">To</option>
                <option
                    v-for="(senaraikapal, index) in senaraikapals"
                    :key="index"
                    :value="senaraikapal.id"
                >
                    {{ senaraikapal.shortform }}
                </option>
            </select>
            <button
                @click="refreshmessage()"
                class="ml-1 shadow appearance-none border rounded w-auto py-2 px-3 text-gray-900 leading-tight focus:outline-none focus:shadow-outline"
            >
                CLR
            </button>
            <!-- <secondary-button
                class="ml-1 hover:bg-gray-700 text-gray-900 font-semibold hover:text-gray-100 py-2 px-4 border border-gray-900 hover:border-transparent rounded"
                @click="refreshmessage()"
                >CLR</secondary-button
            > -->
            <!-- <secondary-button class="ml-1 hover:bg-gray-700 text-gray-900 font-semibold hover:text-gray-100 py-2 px-4 border border-gray-900 hover:border-transparent rounded" @click="refreshmessage()"
                >ADDRESSEE</secondary-button
            > -->
        </div>
        <div v-if="quickguide" style="border-top: 1px solid #e6e6e6">
            <input
                type="text"
                placeholder="Enter some of the keywords"
                v-model="query"
                @keyup="getData()"
                autocomplete="off"
                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-900 leading-tight focus:outline-none focus:shadow-outline"
            />
            <div class="panel-footer" v-if="search_data.length">
                <ul
                    v-for="(data1, index) in search_data"
                    :key="index"
                    class="bg-gray-100 rounded-lg w-full overflow-visible"
                >
                    <a
                        style="cursor: pointer"
                        class="list-group-item block px-4 py-2 text-gray-800 hover:bg-indigo-500 hover:text-white border border-gray-300"
                        @click="getName(data1.Meaning)"
                        >{{ data1.Meaning }}
                    </a>
                </ul>
            </div>
        </div>
    </div>
    <div class="m-1">
        <div style="border-top: 1px solid #e6e6e6" class="grid">
            <span
                rows="3"
                style="min-height: 6rem; white-space: pre-wrap"
                class="shadow appearance-none border border-gray-500 rounded py-2 px-3 leading-tight focus:outline-none focus:shadow-outline"
                >{{ translatemessage }}</span
            >
        </div>
    </div>
    <div class="relative p-3 pl-1 flex justify-end">
        <!-- <div class="ml-1 absolute left-0">
            <select
                @change="choosemessagetype"
                class="block appearance-none w-auto bg-white border border-gray-400 hover:border-gray-500 px-4 py-2 pr-8 rounded shadow leading-tight focus:outline-none focus:shadow-outline"
            >
                <option>Free Text</option>
                <option>Quick Guide</option>
            </select>
        </div> -->
        <button
            @click="customsendMessage('K')"
            class="w-1/12 bg-gray-500 hover:bg-gray-300 text-gray-100 font-semibold hover:text-gray-700 py-2 px-4 border border-gray-500 hover:border-transparent rounded"
        >
            OVER
        </button>
        <button
            @click="customsendMessage('AR')"
            class="w-2/12 mx-2 bg-gray-500 hover:bg-gray-300 text-gray-100 font-semibold hover:text-gray-700 py-2 px-4 border border-gray-500 hover:border-transparent rounded"
        >
            Roger Out
        </button>
        <button
            @click="sendMessage('TIME')"
            class="w-1/12 mx-2 bg-blue-500 hover:bg-blue-300 text-gray-100 font-semibold hover:text-gray-700 py-2 px-4 border border-blue-500 hover:border-transparent rounded"
        >
            TIME
        </button>
        <button
            @click="sendMessage('IX')"
            class="w-1/12 mx-2 bg-yellow-500 hover:bg-yellow-300 text-gray-100 font-semibold hover:text-gray-700 py-2 px-4 border border-yellow-500 hover:border-transparent rounded"
        >
            IX
        </button>
        <button
            @click="sendMessage('RIX')"
            class="w-1/12 bg-red-500 hover:bg-red-300 text-gray-100 font-semibold hover:text-gray-700 py-2 px-4 border border-red-500 hover:border-transparent rounded"
        >
            RIX
        </button>
    </div>
</template>

<script>
export default {
    components: { Input },
    emits: ["messagesent"],
    props: [
        "room",
        "currenteksesais",
        "clickMessage3",
        "senaraikapals",
        "callsigneksesais",
    ],
    data: function () {
        return {
            message: "",
            translatemessage: "",
            quickguide: false,
            query: "",
            search_data: [],
            idkapalindividual: "",
            sendercallsign: "",
        };
    },
    watch: {
        clickMessage3: function (val, oldval) {
            this.message = val;
        },
        message: function (val, oldval) {
            // this.message = this.message.toUpperCase();
            axios
                .get("/grouper/ajax/meaning", {
                    params: {
                        message: this.message,
                    },
                })
                .then((response) => {
                    this.translatemessage = response.data.message;
                })
                .catch((error) => {
                    console.log(error);
                });
        },
    },
    methods: {
        // getData: function () {
        //     this.search_data = [];
        //     axios
        //         .get("/testasdasdasdafdsf", {
        //             params: {
        //                 message: this.query,
        //             },
        //         })
        //         .then((response) => {
        //             this.search_data = response.data.teadtasd;
        //             console.log(this.search_data);
        //         });
        // },
        // getName: function (name) {
        //     this.query = name;
        //     this.search_data = [];
        //     console.log(this.query);
        // },
        // choosemessagetype(e) {
        //     if (e.target.value === "Quick Guide") {
        //         this.quickguide = true;
        //     }
        //     if (e.target.value === "Free Text") {
        //         this.quickguide = false;
        //     }
        // },
        refreshmessage() {
            this.message = "";
            this.sendercallsign = "";
            this.idkapalindividual = "";
        },
        sendMessage(action) {
            if (this.Message == " ") {
                return;
            }
            if (this.idkapalindividual == "") {
                axios
                    .post(
                        "/chat/eksesais/" +
                            this.currenteksesais +
                            "/" +
                            this.room.id +
                            "/message",
                        {
                            message: this.message,
                            action: action,
                            pluckusersOnRoom: this.room.shortform,
                            individual: false,
                            sendercallsign: this.sendercallsign,
                        }
                    )
                    .then((response) => {
                        if (response.status == 200 || response.status == 201) {
                            this.message = "";
                            this.translatemessage = "";
                            // this.sendercallsign = ""
                            this.$emit("messagesent", response.data);
                        }
                    })
                    .catch((error) => {
                        console.log(error);
                    });
            }
            // Individual chat
            else {
                axios
                    .post(
                        "/chat/eksesais/" +
                            this.currenteksesais +
                            "/" +
                            this.room.id +
                            "/message",
                        {
                            message: this.message,
                            action: action,
                            pluckusersOnRoom: this.idkapalindividual,
                            individual: true,
                            sendercallsign: this.sendercallsign,
                        }
                    )
                    .then((response) => {
                        if (response.status == 200 || response.status == 201) {
                            this.message = "";
                            this.translatemessage = " ";
                            // this.sendercallsign = ""
                            this.$emit("messagesent", response.data);
                        }
                    })
                    .catch((error) => {
                        console.log(error);
                    });
            }
        },
        customsendMessage(action) {
            axios
                .post(
                    "/chat/eksesais/" +
                        this.currenteksesais +
                        "/" +
                        this.room.id +
                        "/message",
                    {
                        message: action,
                        action: " ",
                        pluckusersOnRoom: this.room.shortform,
                    }
                )
                .then((response) => {
                    if (response.status == 200|| response.status == 201) {
                        this.message = "";
                        this.translatemessage = " ";
                        this.$emit("messagesent", response.data);
                    }
                })
                .catch((error) => {
                    console.log(error);
                });
        },
    },
    created() {},
};
</script>

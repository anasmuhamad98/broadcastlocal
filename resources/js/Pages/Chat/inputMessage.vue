<script setup>
import Input from "../../Jetstream/Input.vue";
import SecondaryButton from "../../../../vendor/laravel/jetstream/stubs/inertia/resources/js/Jetstream/SecondaryButton.vue";
</script>

<template>
    <div class="relative h-10 m-1">
        <div v-if="quickguide === false" style="border-top: 1px solid #e6e6e6">
            <input
                type="text"
                v-model="message"
                placeholder="Say Something..."
                class="shadow appearance-none border rounded w-4/5 py-2 px-3 text-gray-900 leading-tight focus:outline-none focus:shadow-outline"
            />
            <secondary-button @click="refreshmessage()">Refresh</secondary-button>
        </div>
        <div v-if="quickguide" style="border-top: 1px solid #e6e6e6" class="grid">
            <input
                type="text"
                v-model="message"
                placeholder="v kacmako akpi kamsvioak apokak a0vk a09 0oaoi s..."
                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-900 leading-tight focus:outline-none focus:shadow-outline"
            />
        </div>
    </div>
    <div class="m-1">
        <div style="border-top: 1px solid #e6e6e6" class="grid">
            <textarea
                v-model="translatemessage"

                rows="3"
                class="shadow appearance-none border rounded w-full py-2 px-3 leading-tight focus:outline-none focus:shadow-outline"
            ></textarea>
        </div>
    </div>
    <div class="relative p-3 pl-1 flex justify-end">
        <div class="ml-1 absolute left-0">
            <select
                @change="choosemessagetype"
                class="block appearance-none w-auto bg-white border border-gray-400 hover:border-gray-500 px-4 py-2 pr-8 rounded shadow leading-tight focus:outline-none focus:shadow-outline"
            >
                <option>Free Text</option>
                <option>Quick Guide</option>
            </select>
        </div>
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
    props: ["room", "currenteksesais", "clickMessage3"],
    data: function () {
        return {
            message: "",
            translatemessage: "",
            quickguide: false,
        };
    },
    watch: {
        clickMessage3: function (val, oldval) {
            this.message = val;
        },
        message: function (val, oldval) {
            axios
                .get("/grouper/ajax/meaning", {
                    params: {
                        message: this.message,
                    },
                })
                .then((response) => {
                    this.translatemessage = response.data;
                })
                .catch((error) => {
                    console.log(error);
                });
        },
    },
    methods: {
        choosemessagetype(e) {
            if (e.target.value === "Quick Guide") {
                this.quickguide = true;
            }
            if (e.target.value === "Free Text") {
                this.quickguide = false;
            }
        },
        refreshmessage(){
            this.message = '';
        },
        sendMessage(action) {
            if (this.Message == " ") {
                return;
            }
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
                    }
                )
                .then((response) => {
                    if (response.status == 200) {
                        this.message = "";
                        this.translatemessage = " ";
                        this.$emit("messagesent");
                    }
                })
                .catch((error) => {
                    console.log(error);
                });
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
                    }
                )
                .then((response) => {
                    if (response.status == 200) {
                        this.message = "";
                        this.translatemessage = " ";
                        this.$emit("messagesent");
                    }
                })
                .catch((error) => {
                    console.log(error);
                });
        },
    },
};
</script>

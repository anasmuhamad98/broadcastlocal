<script setup>
import Input from "../../Jetstream/Input.vue";
</script>

<template>
    <div class="relative h-10 m-1">
        <div style="border-top: 1px solid #e6e6e6" class="grid">
            <input
                type="text"
                v-model="message"
                @keyup.enter="sendMessage()"
                placeholder="Say Something..."
                class="col-span-5 outline-none p-1"
            />
        </div>
    </div>
    <div class="m-1">
        <div style="border-top: 1px solid #e6e6e6" class="grid">
            <textarea
                v-model="translatemessage"
                disabled
                rows="3"
            ></textarea>
        </div>
    </div>
    <button
        @click="sendMessage('over')"
        class="place-self-end bg-gray-500 hover:bg-blue-700 p-1 mt-1 rounded text-white"
    >
        over
    </button>
    <button
        @click="sendMessage('roger out')"
        class="place-self-end bg-gray-500 hover:bg-blue-700 p-1 mt-1 rounded text-white"
    >
        roger out
    </button>
    <button
        @click="sendMessage('time')"
        class="place-self-end bg-gray-500 hover:bg-blue-700 p-1 mt-1 rounded text-white"
    >
        time
    </button>
    <button
        @click="sendMessage('ix')"
        class="place-self-end bg-gray-500 hover:bg-blue-700 p-1 mt-1 rounded text-white"
    >
        ix
    </button>
    <button
        @click="sendMessage('rix')"
        class="place-self-end bg-gray-500 hover:bg-blue-700 p-1 mt-1 rounded text-white"
    >
        rix
    </button>
</template>

<script>
export default {
    components: { Input },
    emits: ["messagesent"],
    props: ["room", "currenteksesais"],
    data: function () {
        return {
            message: "",
            translatemessage: "",
        };
    },
    watch: {
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
        sendMessage(action) {
            if (this.Message == " ") {
                return;
            }
            axios
                .post("/chat/eksesais/"+ this.currenteksesais+ '/' + this.room.id + "/message", {
                    message: this.message,
                    action: action,
                })
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

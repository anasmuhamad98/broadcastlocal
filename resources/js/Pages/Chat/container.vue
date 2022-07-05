<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import messageContainer from "./messageContainer.vue";
import InputMessage from "./inputMessage.vue";
import ChatRoomSelection from "./chatRoomSelection.vue";
</script>

<template>
    <AppLayout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                <ChatRoomSelection
                    v-if="currentRoom.id"
                    :rooms="chatRooms"
                    :currentRoom="currentRoom"
                    :eksesaisdetail="eksesaisdetail"
                    v-on:roomchanged="setRoom($event)"
                />
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <message-container :messages="messages" />
                    <input-message
                        :room="currentRoom"
                        :currenteksesais="eksesaisdetail.id"
                        v-on:messagesent="getMessages()"
                    />
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<script>
export default {
    components: {
        messageContainer,
        InputMessage,
        AppLayout,
        ChatRoomSelection,
    },
    props: ["eksesaisdetail"],
    data: function () {
        return {
            chatRooms: [],
            currentRoom: [],
            messages: [],
        };
    },
    mounted() {
        window.Echo.private("eksesais." + this.eksesaisdetail.id).listen(
            "NewChatMessage",
            (e) => {
                this.getMessages();
            }
        );
    },
    unmounted() {
        window.Echo.leave("eksesais." + this.eksesaisdetail.id);
    },
    watch: {
        // currentRoom(val, oldval) {
        //     if (oldval.id) {
        //         this.disconnect(oldval);
        //     }
        //     this.connect();
        // },
    },
    methods: {
        connect() {
            if (this.currentRoom.id) {
                let vm = this;
                this.getMessages();
            }
        },
        disconnect(room) {
            window.Echo.leave("chat." + room.id);
        },
        getRooms() {
            axios
                .get("/chat/rooms/" + this.eksesaisdetail.id)
                .then((response) => {
                    this.chatRooms = response.data;
                    this.setRoom(response.data[0]);
                })
                .catch((error) => {
                    console.log(error);
                });
        },
        setRoom(room) {
            this.currentRoom = room;
            this.getMessages();
        },
        getMessages() {
            axios
                .get(
                    "/chat/eksesais/" +
                        this.eksesaisdetail.id +
                        "/" +
                        this.currentRoom.id +
                        "/messages"
                )
                .then((response) => {
                    this.messages = response.data;
                })
                .catch((error) => {
                    console.log(error);
                });
        },
    },
    created() {
        this.getRooms();
    },
};
</script>

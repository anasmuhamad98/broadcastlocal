<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import messageContainer from "./messageContainer.vue";
import InputMessage from "./inputMessage.vue";
import ChatRoomSelection from "./chatRoomSelection.vue";
import Rightslide from "./rightslide.vue";
import Leftslide from "./leftslide.vue";
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
                    :usersOnRoom="usersOnRoom"
                    :senaraikapals="senaraikapals"
                    v-on:roomchanged="setRoom($event)"
                />
            </h2>
        </template>

        <div class="py-9 relative">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <message-container
                        :messages="messages"
                        :messagesIXs="messagesIXs"
                        v-on:clickmessage2="getClickMessage($event)"
                        v-on:clickIXbutton2="clickIXbutton($event)"
                    />
                    <input-message
                        :room="currentRoom"
                        :currenteksesais="eksesaisdetail.id"
                        :clickMessage3="clickMessage"
                        :pluckusersOnRoom="pluckusersOnRoom"
                        :senaraikapals="senaraikapals"
                        :callsigneksesais="callsigneksesais"
                        v-on:messagesent="getMessages()"
                    />
                </div>
            </div>
        </div>
        <rightslide
            class="absolute right-0 top-1/2"
            :callsigneksesais="callsigneksesais"
            :senaraikapals="senaraikapals"
        />
        <leftslide class="absolute left-0 top-1/2" />
    </AppLayout>
</template>

<script>
export default {
    components: {
        messageContainer,
        InputMessage,
        AppLayout,
        ChatRoomSelection,
        Rightslide,
        Leftslide,
    },
    props: ["eksesaisdetail"],
    data: function () {
        return {
            chatRooms: [],
            currentRoom: [],
            messagesIXs: [],
            messages: [],
            test: [],
            clickMessage: "",
            usersOnRoom: [],
            pluckusersOnRoom: "",
            senaraikapals: [],
            callsigneksesais: [],
        };
    },
    mounted() {
        window.Echo.private("eksesais." + this.eksesaisdetail.id).listen(
            "NewChatMessage",
            (e) => {
                this.getMessages();
                this.getRooms();
            }
        );
    },
    unmounted() {
        window.Echo.leave("eksesais." + this.eksesaisdetail.id);
    },
    methods: {
        getcallsign() {
            axios
                .get("/eksesais/callsign/" + this.eksesaisdetail.id)
                .then((response) => {
                    this.callsigneksesais = response.data;
                });
        },
        clickIXbutton(mesejid) {
            if (
                confirm(
                    "Are you sure to execute " +
                        this.messagesIXs.find(
                            (element) => element.id === mesejid
                        ).message +
                        "?"
                ) == true
            ) {
                this.updateIXMessage(mesejid);
            }
        },
        updateIXMessage(messageid) {
            axios
                .post(
                    "/chat/eksesais/" +
                        this.eksesaisdetail.id +
                        "/" +
                        this.currentRoom.id +
                        "/" +
                        messageid +
                        "/messageId",
                    {}
                )
                .then((response) => {
                    if (response.status == 200) {
                        this.getMessages();
                    }
                })
                .catch((error) => {
                    console.log(error);
                });
        },
        getKapal() {
            axios
                .get("/senaraikapal/" + this.eksesaisdetail.id)
                .then((response) => {
                    this.senaraikapals = response.data;
                })
                .catch((error) => {
                    console.log(error);
                });
        },
        getClickMessage(test) {
            this.clickMessage = test;
            console.log(this.clickMessage);
        },
        connect() {
            if (this.currentRoom.id) {
                let vm = this;
                this.getMessages();
            }
        },
        disconnect(room) {
            window.Echo.leave("chat." + room.id);
        },
        updateSeenMessage() {
            axios
                .post(
                    "/eksesais/" +
                        this.eksesaisdetail.id +
                        "/group/" +
                        this.currentRoom.id +
                        "/updateseenmessage",
                    {}
                )
                .then((response) => {
                    if (response.status == 200) {
                        this.currentRoom.pivot.newMessage = 0;
                        console.log(this.currentRoom);
                    }
                })
                .catch((error) => {
                    console.log(error);
                });
        },
        getRooms() {
            axios
                .get("/chat/rooms/" + this.eksesaisdetail.id)
                .then((response) => {
                    this.chatRooms = response.data;
                })
                .catch((error) => {
                    console.log(error);
                });
        },
        getRoomsFirst() {
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
            this.getUsersonRoom();
            // this.getMessages();
            this.updateSeenMessage();
            console.log(this.usersOnRoom);
        },
        getUsersonRoom() {
            axios
                .get("/room/users/" + this.currentRoom.id)
                .then((response) => {
                    this.usersOnRoom = response.data.usersOnRoom;
                    this.pluckusersOnRoom = response.data.pluckusersOnRoom;
                })
                .catch((error) => {
                    console.log(error);
                });
        },
        getMessages() {
            axios
                .get("/chat/eksesais/" + this.eksesaisdetail.id + "/messages", {
                    params: {
                        chatrooms: this.chatRooms,
                    },
                })
                .then((response) => {
                    this.messages = response.data.mesejbawah;
                    this.messagesIXs = response.data.mesejatas;
                })
                .catch((error) => {
                    console.log(error);
                });
        },
    },
    created() {
        this.getKapal();
        this.getMessages();
        this.getRoomsFirst();
        this.getcallsign();
    },
};
</script>

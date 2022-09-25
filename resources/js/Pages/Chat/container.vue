<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import messageContainer from "./messageContainer.vue";
import InputMessage from "./inputMessage.vue";
import ChatRoomSelection from "./chatRoomSelection.vue";
import Rightslide from "./rightslide.vue";
import Leftslide from "./leftslide.vue";

import { DateTime } from "luxon";
</script>

<template>
    <AppLayout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                <ChatRoomSelection
                    v-if="currentRoom.id"
                    :rooms="chatRooms"
                    :currentRoom="currentRoom"
                    :eksesaisdetail="currenteksesaisdetail"
                    :usersOnRoom="usersOnRoom"
                    :senaraikapals="senaraikapals"
                    v-on:roomchanged="setRoom($event)"
                    v-on:updategroup="getRooms()"
                />
            </h2>
        </template>

        <div class="py-9 relative">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <message-container
                        :messages="messageofeachroomatas"
                        :messagesIXs="messageofeachroombawah"
                        v-on:clickmessage2="getClickMessage($event)"
                        v-on:clickIXbutton2="clickIXbutton($event)"
                    />
                    <input-message
                        :room="currentRoom"
                        :currenteksesais="eksesaisdetail"
                        :clickMessage3="clickMessage"
                        :senaraikapals="senaraikapals"
                        :callsigneksesais="callsigneksesais"
                        v-on:messagesent="pushtoMessage($event)"
                    />
                </div>
            </div>
        </div>
        <rightslide
            class="absolute right-0 top-1/2"
            :callsigneksesais="callsigneksesais"
            :senaraikapals="senaraikapals"
        />
        <!-- <leftslide class="absolute left-0 top-1/2" /> -->
        <audio ref="myAudio" hidden>
            <source src="/musics/tingting.mp3" type="audio/mpeg" /></audio
        ><br />
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
            messageofeachroomatas: [],
            messageofeachroombawah: [],
            allroomswithusers: [],
            currenteksesaisdetail: [],
        };
    },
    mounted() {
        console.log(DateTime.now().toISOTime(), "check for mounted");
        window.Echo.private("eksesais." + this.eksesaisdetail)
            .listen("NewChatMessage", (e) => {
                this.pushtoMessage(e.chatMessage);
            })
            .listen("NewGroupChat", (e) => {
                this.getRooms();
            });
    },
    unmounted() {
        window.Echo.leave("eksesais." + this.eksesaisdetail);
        window.Echo.leave("NewGroupChat");
    },
    methods: {
        getKapal() {
            axios
                .get(
                    "http://taccomm.mafc2.mil.my/api/senaraikapal/" +
                        this.eksesaisdetail
                )
                .then((response) => {
                    this.senaraikapals = response.data;
                    console.log(
                        DateTime.now().toISOTime(),
                        "2. getkapal",
                        this.senaraikapals
                    );
                })
                .catch((error) => {
                    console.log(error);
                });
        },

        getcallsign() {
            axios
                .get("http://taccomm.mafc2.mil.my/api/eksesais/callsign/all")
                .then((response) => {
                    this.callsigneksesais = response.data;

                    console.log(
                        DateTime.now().toISOTime(),
                        "3. getcallsign",
                        this.callsigneksesais
                    );
                });
        },

        getAllRoomsWithUsers() {
            axios
                .get(
                    "http://taccomm.mafc2.mil.my/api/eksesais/" +
                        this.eksesaisdetail +
                        "/rooms/users"
                )
                .then((response) => {
                    this.allroomswithusers = response.data;
                    console.log(
                        DateTime.now().toISOTime(),
                        "4. allroomswithusers",
                        this.allroomswithusers
                    );

                    this.getRoomsFirst(this.allroomswithusers);
                })
                .catch((error) => {
                    console.log(error);
                });
        },

        getRoomsFirst(allrooms) {
            this.chatRooms = allrooms.filter(function (value) {
                return value.isShow == 1;
            });
            console.log(
                DateTime.now().toISOTime(),
                "5. getroomfirst",
                this.chatRooms
            );
            this.setRoomFirst(this.chatRooms[0]);
        },

        setRoomFirst(room) {
            this.currentRoom = room;
            console.log(
                DateTime.now().toISOTime(),
                "6. setroom",
                this.currentRoom
            );

            this.getUsersonRoom(room.id);
            this.getMessages();
            this.updateSeenMessage();
        },

        getUsersonRoom(roomId) {
            this.usersOnRoom = this.allroomswithusers.find(
                (element) => element.id === roomId
            ).users;
            console.log(
                DateTime.now().toISOTime(),
                "7. get users on room",
                this.usersOnRoom
            );
        },

        getMessages() {
            axios
                .get(
                    "http://taccomm.mafc2.mil.my/api/chat/eksesais/" +
                        this.eksesaisdetail +
                        "/messages",
                    {
                        params: {
                            // chatrooms: this.chatRooms,
                            chatroomId: this.currentRoom.id,
                        },
                    }
                )
                .then((response) => {
                    this.messages = response.data.mesejbawah;
                    this.messagesIXs = response.data.mesejatas;
                    // console.log("2. messagebawah", this.messages);
                    // console.log("3. messageatas", this.messagesIXs);
                    this.getMessagesOfEachRoom(this.currentRoom.id);
                    // this.playSound();
                })
                .catch((error) => {
                    console.log(error);
                });
        },

        getMessagesOfEachRoom(room) {
            // console.log('4. before', this.messageofeachroomatas);
            this.messageofeachroomatas = [];
            this.messageofeachroombawah = [];
            this.messageofeachroomatas = this.messages.filter(function (value) {
                return value.chat_room_id == room;
            });
            this.messageofeachroombawah = this.messagesIXs.filter(function (
                value
            ) {
                return value.chat_room_id == room;
            });

            // console.log('5. after', this.messageofeachroomatas);
        },

        pushtoMessage(newmessage) {
            if (newmessage.action == "IX") {
                this.messagesIXs.unshift(newmessage);
                this.messagesIXs.sort(function (a, b) {
                    return a.created_at - b.created_at;
                });
                console.log("IX masuk", this.messagesIXs);
            } else {
                if (newmessage.message.includes("STANDBY EXEC")) {
                    let IXmessageneedtoberemove = newmessage.message.replace(
                        " STANDBY EXEC",
                        ""
                    );
                    let updatemessage = this.messagesIXs.find(
                        (element) => element.message === IXmessageneedtoberemove
                    );
                    let IXmessageneedtoberemoveindex =
                        this.messagesIXs.findIndex(
                            (element) =>
                                element.message === IXmessageneedtoberemove
                        );
                    this.messagesIXs.splice(IXmessageneedtoberemoveindex, 1);
                    updatemessage.action = "-IX";
                    this.pushtoMessage(updatemessage);
                    console.log(this.messagesIXs);
                }
                this.messages.unshift(newmessage);
                this.messages
                    .sort(function (a, b) {
                        return new Date(b.created_at) - new Date(a.created_at);
                    });
            }

            this.getMessagesOfEachRoom(newmessage.chat_room_id);
        },

        clickIXbutton(message) {
            if (
                confirm(
                    "Are you sure to execute " +
                        this.messagesIXs.find(
                            (element) => element.id === message.id
                        ).message +
                        "?"
                ) == true
            ) {
                this.updateIXMessage(message);
            }
        },
        updateIXMessage(message) {
            axios
                .post(
                    "http://taccomm.mafc2.mil.my/api/chat/eksesais/" +
                        this.eksesaisdetail +
                        "/" +
                        this.currentRoom.id +
                        "/" +
                        message.id +
                        "/messageId",
                    {}
                )
                .then((response) => {
                    if (response.status == 200 || response.status == 201) {
                        let updatemessage = this.messagesIXs.find(
                            (element) => element.id === message.id
                        );
                        let updatemessageindex = this.messagesIXs.findIndex(
                            (element) => element.id === message.id
                        );
                        this.messagesIXs.splice(updatemessageindex, 1);
                        updatemessage.action = "-IX";

                        this.pushtoMessage(updatemessage);
                        this.pushtoMessage(response.data);
                        // this.getMessages();
                    }
                })
                .catch((error) => {
                    console.log(error);
                });
        },
        getClickMessage(test) {
            this.clickMessage = test;
            console.log("clickmessage", this.clickMessage);
        },
        updateSeenMessage() {
            axios
                .post(
                    "http://taccomm.mafc2.mil.my/api/eksesais/" +
                        this.eksesaisdetail +
                        "/group/" +
                        this.currentRoom.id +
                        "/updateseenmessage",
                    {}
                )
                .then((response) => {
                    if (response.status == 200) {
                        this.currentRoom.pivot.newMessage = 0;
                    }
                })
                .catch((error) => {
                    console.log(error);
                });
        },
        getRooms() {
            axios
                .get(
                    "http://taccomm.mafc2.mil.my/api/chat/rooms/" +
                        this.eksesaisdetail
                )
                .then((response) => {
                    this.chatRooms = response.data;
                })
                .catch((error) => {
                    console.log(error);
                });
        },

        setRoom(room) {
            this.currentRoom = room;
            this.getUsersonRoom(room.id);
            this.getMessagesOfEachRoom(room.id);
            this.updateSeenMessage();
        },

        geteksesaisdetail() {
            axios
                .get(
                    "http://taccomm.mafc2.mil.my/api/eksesaisdetail/" +
                        this.eksesaisdetail
                )
                .then((response) => {
                    this.currenteksesaisdetail = response.data;
                })
                .catch((error) => {
                    console.log(error);
                });
        },
    },
    created() {
        console.log(DateTime.now().toISOTime(), "1. start");
        this.geteksesaisdetail();
        this.getKapal();
        this.getcallsign();
        this.getAllRoomsWithUsers();
    },
};
</script>

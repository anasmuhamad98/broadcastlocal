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
                    :eksesaisdetail="eksesaisdetail"
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
            audio: new Audio("/musics/tingting.mp3"),
        };
    },
    mounted() {
        console.log(DateTime.now().toISOTime(), "check for mounted");
        window.Echo.private("eksesais." + this.eksesaisdetail)
            .listen("NewChatMessage", (e) => {
                this.pushtoMessage(e.chatMessage);
                // this.getMessages();
                // this.getRooms();
            })
            .listen("NewGroupChat", (e) => {
                this.getRooms();
            });

        // window.Echo.private("eksesais." + this.eksesaisdetail.id +  "." )
        //     .listen("NewChatMessage", (e) => {
        //         this.getMessages();
        //         this.getRooms();
        //     });
    },
    unmounted() {
        window.Echo.leave("eksesais." + this.eksesaisdetail);
        window.Echo.leave("NewGroupChat");
    },
    methods: {
        getKapal() {
            axios
                .get("http://taccomm.mafc2.mil.my/api/senaraikapal/" + this.eksesaisdetail)
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
            axios.get("http://taccomm.mafc2.mil.my/api/eksesais/callsign/all").then((response) => {
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
                .get("http://taccomm.mafc2.mil.my/api/eksesais/" + this.eksesaisdetail + "/rooms/users")
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
            // axios
            //     .get("/chat/rooms/" + this.eksesaisdetail.id)
            //     .then((response) => {
            //         this.chatRooms = response.data;
            //         console.log(
            //             DateTime.now().toISOTime(),
            //             "5. getroomfirst",
            //             this.chatRooms
            //         );
            //         this.setRoomFirst(response.data[0]);
            //     })
            //     .catch((error) => {
            //         console.log(error);
            //     });
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
            // axios
            //     .get("/room/users/" + this.currentRoom.id)
            //     .then((response) => {
            //         this.usersOnRoom = response.data.usersOnRoom;
            //         this.pluckusersOnRoom = response.data.pluckusersOnRoom;
            //         console.log(
            //             DateTime.now().toISOTime(),
            //             "6. user on room",
            //             this.pluckusersOnRoom
            //         );
            //     })
            //     .catch((error) => {
            //         console.log(error);
            //     });
        },

        getMessages() {
            axios
                .get("http://taccomm.mafc2.mil.my/api/chat/eksesais/" + this.eksesaisdetail + "/messages", {
                    params: {
                        // chatrooms: this.chatRooms,
                        chatroomId: this.currentRoom.id,
                    },
                })
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
                console.log("IX", this.messagesIXs);
            } else {
                this.messages.unshift(newmessage);
                this.messages
                    .sort(function (a, b) {
                        return new Date(b.created_at) - new Date(a.created_at);
                    })
                    .sort(function (a, b) {
                        return new Date(b.created_at) - new Date(a.created_at);
                    });
                console.log("jadi la ni", this.messages);
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
                        // console.log("currentroom", this.currentRoom);
                    }
                })
                .catch((error) => {
                    console.log(error);
                });
        },
        getRooms() {
            axios
                .get("http://taccomm.mafc2.mil.my/api/chat/rooms/" + this.eksesaisdetail)
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

        // playSound() {
        //     this.audio.play();
        // },

        // enableLoop() {
        //     this.audio.loop = true;
        //     this.audio.load();
        //     this.$refs.myAudio.play();
        //     this.$refs.myAudio.loop = true;
        //     this.$refs.myAudio.load();
        // },

        // disableLoop() {
        //     this.audio.loop = false;
        //     this.audio.load();
        //     this.$refs.myAudio.loop = false;
        //     this.$refs.myAudio.load();
        // },

        // checkLoop() {
        //     alert(this.audio.loop);
        // },
    },
    created() {
        console.log(DateTime.now().toISOTime(), "1. start");
        this.getKapal();
        // console.log( DateTime.now().toISOTime(), "2. getkapal", this.senaraikapals);
        this.getcallsign();
        // console.log( DateTime.now().toISOTime(), "3. getcallsign", this.callsigneksesais);
        // console.log( DateTime.now().toISOTime(), "4. getroomfirst", this.chatRooms);

        this.getAllRoomsWithUsers();
        console.log('hostnamee: ',window.location.hostname);
    },
};
</script>

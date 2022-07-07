<template>
    <div class="grid grid-cols-2">
        <div class="font-blod text-xl">
            {{ eksesaisdetail.Nama }}: {{ selected.name }}
        </div>
        <div class="flex justify-end">
            <button
                class="mx-1 h-10 px-5 text-gray-700 text-sm transition-colors duration-150 bg-gray-300 rounded-lg focus:shadow-outline hover:bg-indigo-800 hover:text-white"
                v-for="(room, index) in rooms"
                :key="index"
                :class="{active: activeBtn === 'btn'+room.id }"
                @click="activeBtn = 'btn' + room.id"
                v-on:click="$emit('roomchanged', room)"
            >
                <span class="mr-2">{{ room.name }}</span>
                <span v-if="room.pivot.newMessage"
                    class="inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-red-100 bg-red-600 rounded-full"
                    >!</span
                >
            </button>
            <button
                class="mx-1 h-10 px-5 text-indigo-100 transition-colors duration-150 bg-indigo-700 rounded-lg focus:shadow-outline hover:bg-indigo-800"
                type="button"
                v-on:click="toggleModal()"
            >
                +
            </button>
        </div>

        <div>
            <div
                v-if="showModal"
                class="overflow-x-hidden overflow-y-auto fixed inset-0 z-50 outline-none focus:outline-none justify-center items-center flex"
            >
                <div class="relative w-1/3 my-6 mx-auto max-w-6xl">
                    <!--content-->
                    <div
                        class="border-0 rounded-lg shadow-lg relative flex flex-col w-full bg-white outline-none focus:outline-none"
                    >
                        <!--header-->
                        <div
                            class="flex items-start justify-between p-5 border-b border-solid border-slate-200 rounded-t"
                        >
                            <h3 class="text-xl font-semibold">
                                Tambah Kumpulan
                            </h3>
                            <button
                                class="p-1 ml-auto bg-transparent border-0 text-black opacity-70 float-right text-3xl leading-none font-semibold outline-none focus:outline-none"
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
                                for="email"
                                value="Nama Kumpulan"
                                class="my-1 text-slate-500 text-lg leading-relaxed"
                            />
                            <Input
                                type="text"
                                v-model="newRoom"
                                class="p-3 mb-1 placeholder-slate-300 text-slate-600 relative bg-white bg-white rounded text-sm border shadow outline-none focus:outline-none focus:ring w-full"
                            />
                            <div
                                v-for="(senaraikapal, index) in senaraikapals"
                                :key="index"
                            >
                                <label class="text-gray-700">
                                    <input
                                        type="checkbox"
                                        v-model="senaraiKapalTerlibat"
                                        :value="senaraikapal.id"
                                    />
                                    <span class="ml-1">{{
                                        senaraikapal.name
                                    }}</span>
                                </label>
                            </div>
                        </div>
                        <!--footer-->
                        <div
                            class="flex items-center justify-end p-6 border-t border-solid border-slate-200 rounded-b"
                        >
                            <button
                                class="text-red-500 background-transparent font-bold uppercase px-6 py-2 text-sm outline-none focus:outline-none mr-1 mb-1 ease-linear transition-all duration-150"
                                type="button"
                                @click="saveGroup()"
                            >
                                Create Group
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
</template>

<script>
import Label from "../../../../vendor/laravel/jetstream/stubs/inertia/resources/js/Jetstream/Label.vue";
import Input from "../../../../vendor/laravel/jetstream/stubs/inertia/resources/js/Jetstream/Input.vue";

export default {
    props: ["rooms", "currentRoom", "eksesaisdetail"],
    emits: ["roomchanged"],
    data: function () {
        return {
            showModal: false,
            newRoom: "",
            selected: "",
            senaraikapals: [],
            senaraiKapalTerlibat: [],
            activeBtn: "btn1",
        };
    },
    methods: {
        toggleModal: function () {
            this.showModal = !this.showModal;
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
        saveGroup() {
            if (this.newRoom == "") {
                return;
            }
            axios
                .post(
                    "/chat/eksesais/" + this.eksesaisdetail.id + "/createroom",
                    {
                        roomName: this.newRoom,
                        senaraiKapalTerlibat: this.senaraiKapalTerlibat,
                    }
                )
                .then((response) => {
                    if (response.status == 200) {
                        this.newRoom = "";
                        this.senaraiKapalTerlibat = [];
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
        this.selected = this.currentRoom;
        console.log(this.rooms[0].pivot.newMessage)
    },
    components: { Label, Input },
};
</script>

<style>
.active {
    background-color: rgb(67, 56, 202);
    color:white;
}
</style>

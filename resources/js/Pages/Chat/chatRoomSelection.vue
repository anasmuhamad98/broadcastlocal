<template>
<div class="grid grid-cols-2">
    <div class="font-blod text-xl">
       {{eksesaisdetail.Nama}}: {{selected.name}}
    </div>
    <div>
        <select v-model='selected' @change="$emit('roomchanged', selected)" class="float-right">
            <option v-for="(room, index) in rooms" :key="index" :value="room">
                {{room.name}}
            </option>
        </select>

 <div>
                <button
                    class="bg-pink-500 text-white active:bg-pink-600 font-bold uppercase text-sm px-6 py-3 rounded shadow hover:shadow-lg outline-none focus:outline-none mr-1 mb-1 ease-linear transition-all duration-150"
                    type="button"
                    v-on:click="toggleModal()"
                >
                    create new group
                </button>
                <div
                    v-if="showModal"
                    class="overflow-x-hidden overflow-y-auto fixed inset-0 z-50 outline-none focus:outline-none justify-center items-center flex"
                >
                    <div class="relative w-auto my-6 mx-auto max-w-6xl">
                        <!--content-->
                        <div
                            class="border-0 rounded-lg shadow-lg relative flex flex-col w-full bg-white outline-none focus:outline-none"
                        >
                            <!--header-->
                            <div
                                class="flex items-start justify-between p-5 border-b border-solid border-slate-200 rounded-t"
                            >
                                <h3 class="text-3xl font-semibold">
                                    Modal Title
                                </h3>
                                <button
                                    class="p-1 ml-auto bg-transparent border-0 text-black opacity-5 float-right text-3xl leading-none font-semibold outline-none focus:outline-none"
                                    v-on:click="toggleModal()"
                                >
                                    <span
                                        class="bg-transparent text-black opacity-5 h-6 w-6 text-2xl block outline-none focus:outline-none"
                                    >
                                        ×
                                    </span>
                                </button>
                            </div>
                            <!--body-->
                            <div class="relative p-6 flex-auto">
                                <Label
                                    for="email"
                                    value="Nama group baru"
                                    class="my-4 text-slate-500 text-lg leading-relaxed"
                                />
                                <Input
                                    type="text"
                                    v-model="newRoom"
                                    class="px-3 py-3 placeholder-slate-300 text-slate-600 relative bg-white bg-white rounded text-sm border-0 shadow outline-none focus:outline-none focus:ring w-full"
                                />
                                <div v-for="(senaraikapal, index) in senaraikapals" :key="index">
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
                                    class="text-red-500 bg-transparent border border-solid border-red-500 hover:bg-red-500 hover:text-white active:bg-red-600 font-bold uppercase text-sm px-6 py-3 rounded outline-none focus:outline-none mr-1 mb-1 ease-linear transition-all duration-150"
                                    type="button"
                                    v-on:click="toggleModal()"
                                >
                                    Close
                                </button>
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
</div>
</template>

<script>
import Label from '../../../../vendor/laravel/jetstream/stubs/inertia/resources/js/Jetstream/Label.vue';
import Input from '../../../../vendor/laravel/jetstream/stubs/inertia/resources/js/Jetstream/Input.vue';

export default{
    props: ["rooms", "currentRoom", "eksesaisdetail"],
    data: function () {
        return {
            showModal: false,
            newRoom: "",
            selected: "",
            senaraikapals: [],
            senaraiKapalTerlibat: [],
        };
    },
    methods: {
        toggleModal: function () {
            this.showModal = !this.showModal;
        },
        getKapal(){
            axios
                .get("/senaraikapal/" + this.eksesaisdetail.id)
                .then((response) => {
                    this.senaraikapals = response.data;
                })
                .catch((error) => {
                    console.log(error);
                });
        },
        saveGroup(){
            if (this.newRoom == "") {
                return;
            }
            axios
                .post("/chat/eksesais/" + this.eksesaisdetail.id + "/createroom", {
                    roomName: this.newRoom,
                })
                .then((response) => {
                    if (response.status == 200) {
                        this.newRoom = "";
                        this.showModal = !this.showModal;
                    }
                })
                .catch((error) => {
                    console.log(error);
                });

        }
    },
    created() {
        this.getKapal();
        this.selected = this.currentRoom;
    },
    components: { Label, Input }
}
</script>

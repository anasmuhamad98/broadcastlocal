<template>
    <div>
        <div id="mySidenav" class="sidenav-right">
            <a href="javascript:void(0)" class="closebtn" @click="closeNav()"
                >&times;</a
            >
            <table
                class="text-white table-auto border-collapse border border-slate-400 w-4/5 m-auto"
            >
                <thead>
                    <tr>
                        <th class="border border-slate-300">Callsign</th>
                        <th class="border border-slate-300">Callsign</th>
                    </tr>
                </thead>
                <tbody class="h-auto overflow-hidden ">
                    <tr
                        v-for="(callsign, index) in callsigneksesais"
                        :key="index"
                        class="text-center"
                    >
                        <td class="border border-slate-300">
                            {{ callsign.callsign1 }}
                        </td>
                        <td class="border border-slate-300">
                            {{ callsign.callsign2 }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <!-- <div class="m-3"><input type="text" class="w-1/3" placeholder="CTO" /><input type="text"  class="w-1/3" placeholder="A1"/> <button
                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-full"
            >
                +
            </button></div> -->

            <table
                class="text-white table-auto border-collapse border border-slate-400 w-4/5 m-auto mt-6"
            >
                <thead>
                    <tr>
                        <th class="border border-slate-300">Kapal</th>
                        <th class="border border-slate-300">Callsign</th>
                    </tr>
                </thead>
                <tbody class="h-auto overflow-hidden">
                    <tr
                        v-for="(kapal, index) in senaraikapals"
                        :key="index"
                        class="text-center"
                    >
                        <td class="border border-slate-300">
                            {{ kapal.shortform }}
                        </td>
                        <td class="border border-slate-300">
                            <span v-if="kapal.callsign">{{
                                kapal.callsign.callsign
                            }}</span>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <span class="sidenav-button" @click="openNav()"
            >&#8249;<span class="sidenav-button-text">CS KAPAL</span></span
        >
    </div>
</template>

<script>
export default {
    props: ["callsigneksesais", "senaraikapals"],
    methods: {
        openNav() {
            document.getElementById("mySidenav").style.width = "30%";
        },

        closeNav() {
            document.getElementById("mySidenav").style.width = "0";
        },
    },
};
</script>

<style>
body {
    font-family: "Lato", sans-serif;
}

.sidenav-right {
    height: 100%;
    width: 0;
    position: fixed;
    z-index: 1;
    top: 0;
    right: 0;
    background-color: #111;
    overflow-x: hidden;
    transition: 0.5s;
    padding-top: 60px;
}

.sidenav-right a {
    padding: 8px 8px 8px 32px;
    text-decoration: none;
    font-size: 25px;
    color: #818181;
    display: block;
    transition: 0.3s;
}

.sidenav-right a:hover {
    color: #f1f1f1;
}

.sidenav-right .closebtn {
    position: absolute;
    top: 0;
    right: 25px;
    font-size: 36px;
    margin-left: 50px;
}

@media screen and (max-height: 450px) {
    .sidenav-right {
        padding-top: 15px;
    }
    .sidenav-right a {
        font-size: 18px;
    }
}

.sidenav-button {
    font-size: 120px;
    cursor: pointer;
    background-color: gray;
    color: white;
    border-radius: 10px;
}

.sidenav-button-text {
    font-size: 20px !important;
    writing-mode: vertical-lr;
    letter-spacing: -0.7rem;
}
</style>

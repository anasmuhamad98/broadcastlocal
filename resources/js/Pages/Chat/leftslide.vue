<template>
    <div>
        <div id="mySidenavleft" class="sidenav-left">
            <a href="javascript:void(0)" class="closebtn" @click="closeNav()"
                >&times;</a
            >
            <a href="#">About</a>
            <a href="#">Services</a>
            <a href="#">Clients</a>
            <a href="#">Contact</a>
        </div>
        <span class="sidenav-button" @click="openNav()"><span class="sidenav-button-text">TASK ORG</span>&#8250;</span>
    </div>
</template>

<script>
export default {
    methods: {
        openNav() {
            document.getElementById("mySidenavleft").style.width = "100%";
        },

        closeNav() {
            document.getElementById("mySidenavleft").style.width = "0";
        },
    },
};
</script>

<style>
body {
    font-family: "Lato", sans-serif;
}

.sidenav-left {
    height: 100%;
    width: 0;
    position: fixed;
    z-index: 1;
    top: 0;
    left: 0;
    background-color: #111;
    overflow-x: hidden;
    transition: 0.5s;
    padding-top: 60px;
}

.sidenav-left a {
    padding: 8px 8px 8px 32px;
    text-decoration: none;
    font-size: 25px;
    color: #818181;
    display: block;
    transition: 0.3s;
}

.sidenav-left a:hover {
    color: #f1f1f1;
}

.sidenav-left .closebtn {
    position: absolute;
    top: 0;
    right: 25px;
    font-size: 36px;
    margin-left: 50px;
}

@media screen and (max-height: 450px) {
    .sidenav-left {
        padding-top: 15px;
    }
    .sidenav-left a {
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
    font-size:20px !important;
    text-orientation: upright;
}
</style>

<script setup>
import { Head, Link, useForm } from "@inertiajs/inertia-vue3";
import JetAuthenticationCard from "@/Jetstream/AuthenticationCard.vue";
import JetAuthenticationCardLogo from "@/Jetstream/AuthenticationCardLogo.vue";
import JetButton from "@/Jetstream/Button.vue";
import JetInput from "@/Jetstream/Input.vue";
import JetCheckbox from "@/Jetstream/Checkbox.vue";
import JetLabel from "@/Jetstream/Label.vue";
import JetValidationErrors from "@/Jetstream/ValidationErrors.vue";
import Auth from "./Auth";
import axios from "axios";

defineProps({
    canResetPassword: Boolean,
    status: String,
});
const form = useForm({
    email: "",
    password: "",
    remember: false,
});

const submit = () => {
    form.transform(data => ({
        ...data,
        remember: form.remember ? 'on' : '',
    })).post('/login', {
        onFinish: () => form.reset('password'),
    });
    // axios
    //             .post(
    //                 "/auth/login" ,
    //                 {
    //                     email: form.email,
    //                     password: form.password,
    //                     remember: form.remember,
    //                 }
    //             )
    //             .then((response) => {
    //                 Auth.login(response.data.token,'lekir'); //set local storage
    //                 console.log(response.data.token);
    //                 console.log(window.localStorage.getItem('user'));
    //                 this.$inertia.visit('/eksesais');
    //                 // window.location.href = 'https://www.google.com';
    //             })
    //             .catch((error) => {
    //                 console.log('x jadi');
    //                 console.log(error);
    //             });
};
</script>

<template>
    <Head title="Log in" />

    <JetAuthenticationCard>
        <template #logo>
            <JetAuthenticationCardLogo />
        </template>

        <JetValidationErrors class="mb-4" />

        <div v-if="status" class="mb-4 font-medium text-sm text-green-600">
            {{ status }}
        </div>

        <form @submit.prevent="submit">
            <div>
                <JetLabel for="email" value="Email" />
                <JetInput
                    id="email"
                    v-model="form.email"
                    type="email"
                    class="mt-1 block w-full"
                    required
                    autofocus
                />
            </div>

            <div class="mt-4">
                <JetLabel for="password" value="Password" />
                <JetInput
                    id="password"
                    v-model="form.password"
                    type="password"
                    class="mt-1 block w-full"
                    required
                    autocomplete="current-password"
                />
            </div>

            <div class="block mt-4">
                <label class="flex items-center">
                    <JetCheckbox
                        v-model:checked="form.remember"
                        name="remember"
                    />
                    <span class="ml-2 text-sm text-gray-600">Remember me</span>
                </label>
            </div>

            <div class="flex items-center justify-end mt-4">
                <Link
                    v-if="canResetPassword"
                    :href="route('password.request')"
                    class="underline text-sm text-gray-600 hover:text-gray-900"
                >
                    Forgot your password?
                </Link>

                <JetButton
                    class="ml-4"
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                >
                    Log in
                </JetButton>

                <!-- <button v-on:click="test123">asdasdasd</button> -->
            </div>
        </form>
    </JetAuthenticationCard>
</template>

<!-- <script>
export default {
    methods: {
        test123() {
            axios
                .post("/testasdasdasdafdsf")
                .then((response) => {this.$inertia.visit('/eksesais')
                    // console.log(this.$inertia.visit('/eksesais'));
                })
                .catch((error) => {
                    console.log("x jadi");
                    console.log(error);
                });
        },
    },
};
</script> -->

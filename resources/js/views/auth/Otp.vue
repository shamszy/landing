<template>
    <div
        class="flex min-h-full flex-1 flex-col justify-center px-6 py-12 lg:px-8"
    >
        <div class="sm:mx-auto sm:w-full sm:max-w-sm">
            <router-link to="/">
                <img
                    class="mx-auto h-10 w-auto"
                    src="https://tailwindui.com/img/logos/mark.svg?color=indigo&shade=600"
                    alt="Your Company"
                />
            </router-link>
            <h2
                class="mt-10 text-center text-2xl font-bold leading-9 tracking-tight text-gray-900"
            >
               Verify OTP
            </h2>
        </div>

        <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">
            <form class="space-y-6" action="#">
                <div>
                    <label
                        for="email"
                        class="block text-sm font-medium leading-6 text-gray-900"
                        >Enter OTP</label
                    >
                    <div class="mt-2">
                        <input
                            id="email"
                            v-model="user.email"
                            type="text"
                            required=""
                            class="block w-full rounded-md border-0 p-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                        />
                    </div>
                </div>

                <!-- <div>
                    <div class="flex items-center justify-between">
                        <label
                            for="password"
                            class="block text-sm font-medium leading-6 text-gray-900"
                            >Password</label
                        >
                        <div class="text-sm">
                            <router-link
                                to="/forgot-password"
                                class="font-semibold text-indigo-600 hover:text-indigo-500"
                                >Forgot password..?</router-link
                            >
                        </div>
                    </div>
                    <div class="mt-2">
                        <input
                            id="password"
                            v-model="user.password"
                            type="password"
                            autocomplete="current-password"
                            required=""
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                        />
                    </div>
                </div> -->
                <!-- <div>
                    <button @click="notify">Notify !</button>
                </div> -->
                <div>
                    <button
                        type="button"
                        @click="Otp()"
                        class="flex w-full justify-center rounded-md  bg-indigo-600 px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
                    >
                       Verify
                    </button>
                </div>
            </form>

            <p class="mt-10 text-center text-sm text-gray-500">
                <!-- Not a member?
                {{ " " }} -->
                <router-link
                    to="/register"
                    class="font-semibold leading-6 text-indigo-600 hover:text-indigo-500"
                    >Resend OTP</router-link
                >
            </p>
        </div>
    </div>
</template>

<script>
import { ref } from "vue";
import store from "../../store";
import router from "../../router";
import axios from "axios";

export default {
    name: "Otp",
    setup() {
        const user = ref({
            email: "",
            password: "",
        });
        const Otp = async () => {
            const notify = () => {
                toast("Akpos", {
                    autoClose: 1000,
                }); // ToastOptions
            };
            console.log("kkkkk");
            let api_url = import.meta.env.VITE_MIX_API_BASE_URL + "verify-otp";
            console.log(api_url);
            try {
                const response = await axios.post(api_url, {
                    otpCode: user.value.email,
                    type: "verification",
                });
                localStorage.setItem("token", response.data.token);
                await store.dispatch("user", response.data.user);
                await router.push("/dashboard");
            } catch (e) {
                console.log(e.response);
            }
        };
        return { user, Otp };
    },
};
</script>

<style scoped></style>

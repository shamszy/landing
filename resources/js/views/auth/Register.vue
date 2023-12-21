<template>
    <div class="bg-cover bg-center bg-fixed" style="background-image: url('https://plus.unsplash.com/premium_photo-1682144351190-9034a7c3b3a8?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D')">
    <div class="h-auto flex justify-center items-center">
        <div class="bg-white mx-4 p-8 rounded shadow-md w-full md:w-1/2 lg:w-1/3">
            <h1 class="text-3xl font-bold mb-8 text-center">Register</h1>
            <form class="space-y-6" action="#" method="POST">
                <div>
                    <label
                        for="email"
                        class="block text-sm font-medium leading-6 text-gray-900"
                        >Company Name</label
                    >
                    <div class="mt-2">
                        <input
                            id="name"
                            v-model="user.name"
                            type="text"
                            required=""
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 px-2 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                        />
                    </div>
                </div>

                <div>
                    <label
                        for="email"
                        class="block text-sm font-medium leading-6 text-gray-900"
                        >Company Email</label
                    >
                    <div class="mt-2">
                        <input
                            id="email"
                            v-model="user.email"
                            type="email"
                            autocomplete="email"
                            required=""
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 px-2 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                        />
                    </div>
                </div>
                <div>
                    <label
                        for="email"
                        class="block text-sm font-medium leading-6 text-gray-900"
                        >Company Phone Number</label
                    >
                    <div class="mt-2">
                        <input
                            id="phoneNumber"
                            v-model="user.phoneNumber"
                            type="text"
                            required=""
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 px-2 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                        />
                    </div>
                </div>
                <div>
                    <label
                        for="email"
                        class="block text-sm font-medium leading-6 text-gray-900"
                        >Company Address</label
                    >
                    <div class="mt-2">
                        <input
                            id="address"
                            v-model="user.address"
                            type="text"
                            required=""
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 px-2 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                        />
                    </div>
                </div>
                <div>
                    <label
                        for="email"
                        class="block text-sm font-medium leading-6 text-gray-900"
                        >Company CAC Number</label
                    >
                    <div class="mt-2">
                        <input
                            id="cacNumber"
                            v-model="user.cacNumber"
                            type="text"
                            required=""
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 px-2 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                        />
                    </div>
                </div>
                <div>
                    <label
                        for="email"
                        class="block text-sm font-medium leading-6 text-gray-900"
                        >Password</label
                    >
                    <div class="mt-2">
                        <input
                            id="password"
                            v-model="user.password"
                            type="password"
                            required=""
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset px-2 ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                        />
                    </div>
                </div>
                <div>
                    <label
                        for="email"
                        class="block text-sm font-medium leading-6 text-gray-900"
                        >Password Confirmation</label
                    >
                    <div class="mt-2">
                        <input
                            id="passwordConfirmation"
                            v-model="user.password_confirmation"
                            type="password"
                            required=""
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset px-2 ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                        />
                    </div>
                </div>

                <div>
                    <button
                        type="button"
                        @click="logIn()"
                        class="flex w-full justify-center rounded-md bg-green-700 px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-green-600 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-green-700"
                    >
                        Register
                    </button>
                    <div class="mt-4 text-center">
                    <p class="text-sm text-gray-600">Already have an account? <a href="/login" class="font-bold text-green-600 no-underline hover:text-green-400">Login</a></p>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
</template>

<script>
import { ref } from "vue";
import store from "../../store";
import router from "../../router";
import axios from "axios";

export default {
    name: "Login",
    setup() {
        const user = ref({
            // email : '',
            // password : ''
            name: "",
            address: "",
            phoneNumber: "",
            cacNumber: "RC: 1506432",
            email: "",
            password: "",
            password_confirmation: "",
        });
        const logIn = async () => {
            // alert("Akpos");
            let api_url = import.meta.env.VITE_MIX_API_BASE_URL + "companies";
            // let api_url = process.env.MIX_API_BASE_URL + "companies";
            try {
                const response = await axios.post(api_url, {
                    // email: user.value.email,
                    // password: user.value.password,
                    // ...user
                    name: user.value.name,
                    address: user.value.address,
                    phoneNumber: user.value.phoneNumber,
                    cacNumber: 4456432,
                    email: user.value.email,
                    password: user.value.password,
                    password_confirmation: user.value.password_confirmation,
                });
                localStorage.setItem("token", response.data.token);
                await store.dispatch("user", response.data.user);
                await router.push("/verify-otp");
            } catch (e) {
                console.log(e);
                // toast.error(e.response, {
                //     position: "top-right",
                // });
            }
        };
        return { user, logIn };
    },
};
</script>

<style scoped></style>

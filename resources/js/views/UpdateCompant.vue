<template>
    <div>
        <button @click="ss">Open Modal</button>

        <ModalComponent :show="showModal">
            <div class="full flex justify-between items-start">
                <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">
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
                                class="flex w-full justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
                            >
                                Sign in
                            </button>
                        </div>
                    </form>

                    <p class="mt-10 text-center text-sm text-gray-500">
                        Not a member?
                        {{ " " }}
                        <router-link
                            to="/login"
                            class="font-semibold leading-6 text-indigo-600 hover:text-indigo-500"
                            >Login</router-link
                        >
                    </p>
                </div>
                <p
                    @click="ss"
                    class="px-1.5 bg-red-400 text-white font-bold rounded-full hover:cursor-pointer"
                >
                    X
                </p>
            </div>
        </ModalComponent>
    </div>
</template>

<script setup>
import ModalComponent from "@/components/ModalComponent.vue";
import { onMounted, ref } from "vue";

// const { openModal, closeModal } = provide();
const showModal = ref(false);

const fetchData = async () => {
    let api_url = import.meta.env.VITE_MIX_API_BASE_URL + "companies";
    // const response = await axios.post(api_url, {

    try {
        const response = await axios.get(api_url, {
            headers: {
                Authorization: `Bearer ${localStorage.getItem("token")}`, // Replace with your actual token
            },
        });
        // data.value = response.data;
        console.log(response);
        tableData.value = response?.data?.data?.map((e) => ({
            id: e?.id,
            name: e?.name,
            address: e?.address,
            phone_number: e?.phone_number,
            cac_number: e?.cac_number,
            slug: e?.slug,
            created_at: e?.created_at,
            updated_at: e?.updated_at,
        }));
        console.log(tableData.value);
    } catch (error) {
        console.error("Error fetching data:", error);
    }
};

const ss = () => {
    showModal.value = !showModal.value;
    console.log(showModal.value);
};

const user = ref({
    // email : '',
    // password : ''
    name: "",
    address: "",
    phoneNumber: "",
    cacNumber: 4456432,
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
        await router.push("/dashboard");
    } catch (e) {
        console.log(e);
        // toast.error(e.response, {
        //     position: "top-right",
        // });
    }
};
onMounted(() => {
    fetchData();
});
</script>

<style scoped>
/* Parent component styles go here */
</style>

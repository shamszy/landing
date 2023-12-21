<template>
    <div>
        <table class="min-w-full border border-gray-300">
            <thead>
                <tr class="bg-gray-100">
                    <th class="border px-4 py-2">Name</th>
                    <th class="border px-4 py-2">Company Address</th>
                    <th class="border px-4 py-2">Phone Number</th>
                    <th class="border px-4 py-2">CAC Number</th>
                    <th class="border px-4 py-2">Action</th>
                </tr>
            </thead>
            <tbody>
                <tr
                    v-for="(item, index) in data"
                    :key="index"
                    class="hover:bg-gray-200"
                >
                    <td class="border px-4 py-2">{{ item.name }}</td>
                    <td class="border px-4 py-2">{{ item.address }}</td>
                    <td class="border px-4 py-2">{{ item.phone_number }}</td>
                    <td class="border px-4 py-2">{{ item.cac_number }}</td>
                    <td class="border px-4 py-2">
                        <button class="p-2 bg-yellow-400 text-black mr-1">
                            Suspend
                        </button>
                        <button
                            @click="ss(item)"
                            class="p-2 bg-purple-500 mr-1 text-white"
                        >
                            Update
                        </button>
                        <button
                            @click="handleClick(item)"
                            class="p-2 bg-red-400 text-white"
                        >
                            Delete
                        </button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <MOdalComponent :show="showModal">
        <div class="w-full flex justify-between items-start">
            <div class="w-full flex justify-between items-start">
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
                            <button
                                type="button"
                                @click="handleupdate"
                                class="flex w-full justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
                            >
                                Update
                            </button>
                        </div>
                    </form>
                </div>
                <p
                    @click="ss"
                    class="px-1.5 bg-red-400 text-white font-bold rounded-full hover:cursor-pointer"
                >
                    X
                </p>
            </div>
        </div>
    </MOdalComponent>
</template>

<script setup>
import { ref, defineProps, defineEmits } from "vue";
import MOdalComponent from "./MOdalComponent.vue";
import UpdateCompant from "../views/UpdateCompant.vue";
import axios from "axios";
const showModal = ref(false);

const ss = (item) => {
    showModal.value = !showModal.value;
    user.value = { ...item };
    user.value.name = item.name;
    user.value.phoneNumber = item.phone_number;
    user.value.cacNumber = item.cac_number;
    user.value.address = item.address;
    console.log(user.value);
};

const { data } = defineProps(["data"]);
const user = ref({
    // email : '',
    // password : ''
    name: "",
    address: "",
    phoneNumber: "",
    cacNumber: RC154893,
    email: "",
});

const emit = defineEmits(["delete-clicked", "update-clicked"]);

const handleClick = (item) => {
    emit("delete-clicked", item);
};
const handleupdate = async () => {
    console.log(user.value);
    let api_url =
        import.meta.env.VITE_MIX_API_BASE_URL +
        `companies/${user?.value?.slug}`;

    try {
        const response = await axios.patch(
            api_url,
            {
               name: user.value.name,
            address: user.value.address,
            phoneNumber: user.value.phoneNumber,
            cacNumber: RC154893,
            },
            {
                headers: {
                    Authorization: `Bearer ${localStorage.getItem("token")}`,
                },
            }
        );

        if(response){
            window.location.reload();
        }
        // data.value = response.data;
        // fetchData(response);
    } catch (error) {
        console.error("Error fetching data:", error);
    }

  
};

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
            cacNumber: RC154893,
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
</script>

<style scoped>
/* No additional custom styling needed as we're using Tailwind CSS classes */
</style>

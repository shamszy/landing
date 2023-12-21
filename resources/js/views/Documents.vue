<template>
    <div>
        <AuthHeader />

        <div class="lg:pl-72">
            <AuthSideBar />

            <main class="py-10">
                <div class="px-4 sm:px-6 lg:px-8">
                    <div>
                        <div class="flex justify-between w-full items-start">
                            <h1 class="text-3xl font-bold my-3">Categories</h1>
                            <button
                                @click="openModal"
                                class="p-2 bg-purple-500 mr-1 text-white"
                            >
                                Create Category
                            </button>
                        </div>

                        <div>
                            <CategoryTable
                                :data="tableData"
                                @delete-clicked="deleteData"
                                @update-clicked="updateData"
                            />
                        </div>

                        <MOdalComponent :show="showModalCreate">
                            <div
                                class="w-full flex justify-between items-start"
                            >
                                <div
                                    class="w-full flex justify-between items-start"
                                >
                                    <div
                                        class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm"
                                    >
                                        <form
                                            class="space-y-6"
                                            action="#"
                                            method="POST"
                                        >
                                            <div>
                                                <label
                                                    for="email"
                                                    class="block text-sm font-medium leading-6 text-gray-900"
                                                    >Category Name</label
                                                >
                                                <div class="mt-2">
                                                    <input
                                                        id="name"
                                                        v-model="useCreate.name"
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
                                                    >Description</label
                                                >
                                                <div class="mt-2">
                                                    <input
                                                        id="address"
                                                        v-model="
                                                            useCreate.description
                                                        "
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
                                                    >Payment</label
                                                >
                                                <div class="mt-2">
                                                    <input
                                                        id="cacNumber"
                                                        v-model="
                                                            useCreate.annualPayment
                                                        "
                                                        type="text"
                                                        required=""
                                                        class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 px-2 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                                                    />
                                                </div>
                                            </div>

                                            <div>
                                                <button
                                                    type="button"
                                                    @click="createData"
                                                    class="flex w-full justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
                                                >
                                                    Create Category
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                    <p
                                        @click="openModal"
                                        class="px-1.5 bg-red-400 text-white font-bold rounded-full hover:cursor-pointer"
                                    >
                                        X
                                    </p>
                                </div>
                            </div>
                        </MOdalComponent>
                    </div>
                </div>
            </main>
        </div>
    </div>
</template>

<script setup>
import AuthHeader from "../components/AuthHeader.vue";
import AuthSideBar from "../components/AuthSideBar.vue";
// import CategoryTable from "../components/CategoryTable.vue";

import { ref, onMounted } from "vue";
import axios from "axios";
import CategoryTable from "../components/CategoryTable.vue";
import MOdalComponent from "../components/MOdalComponent.vue";

const data = ref([]); // Placeholder for API response data
const tableData = ref([]); // Placeholder for API response data

const useCreate = ref({
    name: "",
    description: " ",
    annualPayment: 0,
});
const showModalCreate = ref(false);

const showModal = ref(false);

const openModal = () => {
    showModalCreate.value = !showModalCreate.value;
};

const fetchData = async () => {
    let api_url = import.meta.env.VITE_MIX_API_BASE_URL + "categories";
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
            description: e?.address,
            annualPayment: e?.phone_number,
            // cac_number: e?.cac_number,
            slug: e?.slug,
            created_at: e?.created_at,
            updated_at: e?.updated_at,
        }));
        console.log(tableData.value);
    } catch (error) {
        console.error("Error fetching data:", error);
    }
};

const deleteData = async (slug) => {
    let api_url =
        import.meta.env.VITE_MIX_API_BASE_URL + `companies/${slug?.slug}`;
    // const response = await axios.post(api_url, {

    try {
        const response = await axios.delete(api_url, {
            headers: {
                Authorization: `Bearer ${localStorage.getItem("token")}`,
            },
        });
        // data.value = response.data;
        fetchData(response);
    } catch (error) {
        console.error("Error fetching data:", error);
    }
};

const createData = async (slug) => {
    console.log(slug);
    let api_url =
        import.meta.env.VITE_MIX_API_BASE_URL + `categories`;
    // const response = await axios.post(api_url, {

    try {
        const response = await axios.post(
            api_url,
            {
                name: useCreate?.value?.name,
                description: useCreate?.value?.description,
                annualPayment: useCreate?.value?.annualPayment,
            },
            {
                headers: {
                    Authorization: `Bearer ${localStorage.getItem("token")}`,
                },
            }
        );
        // data.value = response.data;
        fetchData(response);
    } catch (error) {
        console.error("Error fetching data:", error);
    }
};

const suspendData = async (slug) => {
    let api_url =
        import.meta.env.VITE_MIX_API_BASE_URL + `companies/${slug?.slug}`;
    // const response = await axios.post(api_url, {

    try {
        const response = await axios.delete(api_url, {
            headers: {
                Authorization: `Bearer ${localStorage.getItem("token")}`,
            },
        });
        // data.value = response.data;
        fetchData(response);
    } catch (error) {
        console.error("Error fetching data:", error);
    }
};

onMounted(() => {
    fetchData();
});
</script>

<style scoped>
/* Add your CSS styling here */
</style>

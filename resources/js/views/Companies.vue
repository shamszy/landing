<template>
    <div>
        <AuthHeader />

        <div class="lg:pl-72">
            <AuthSideBar />

            <main class="py-10">
                <div class="px-4 sm:px-6 lg:px-8">
                    <div>
                        <h1 class="text-3xl font-bold my-3">Company List</h1>
                        <TableComponent
                            :data="tableData"
                            @delete-clicked="deleteData"
                            @update-clicked="updateData"
                        />
                    </div>
                </div>
            </main>
        </div>

       
    </div>
</template>

<script setup>
import AuthHeader from "../components/AuthHeader.vue";
import AuthSideBar from "../components/AuthSideBar.vue";
import TableComponent from "../components/TableComponent.vue";

import { ref, onMounted } from "vue";
import axios from "axios";

const data = ref([]); // Placeholder for API response data
const tableData = ref([]); // Placeholder for API response data

const showModal = ref(false);

const ss = () => {
    showModal.value = !showModal.value;
};

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

const updateData = async (slug) => {
    console.log(slug)
    // let api_url =
    //     import.meta.env.VITE_MIX_API_BASE_URL + `companies/${slug?.slug}`;
    // // const response = await axios.post(api_url, {

    // try {
    //     const response = await axios.patch(api_url, {
    //         headers: {
    //             Authorization: `Bearer ${localStorage.getItem("token")}`,
    //         },
    //     });
    //     // data.value = response.data;
    //     fetchData(response);
    // } catch (error) {
    //     console.error("Error fetching data:", error);
    // }
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

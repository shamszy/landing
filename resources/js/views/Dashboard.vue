<template>
    <div>
        <AuthHeader />

        <div class="lg:pl-72">

            <AuthSideBar />

            <main class="py-10">
                <div class="px-4 sm:px-6 lg:px-8">
                    <!-- Your content -->
                </div>
            </main>

        </div>
    </div>
</template>

<script setup name="Dashboard">

import AuthHeader from "../components/AuthHeader.vue";
import AuthSideBar from "../components/AuthSideBar.vue";

</script>

<style scoped>

</style>

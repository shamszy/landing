<template>
    <TransitionRoot as="template" :show="sidebarOpen">
        <Dialog
            as="div"
            class="relative z-50 lg:hidden"
            @close="sidebarOpen = false"
        >
            <TransitionChild
                as="template"
                enter="transition-opacity ease-linear duration-300"
                enter-from="opacity-0"
                enter-to="opacity-100"
                leave="transition-opacity ease-linear duration-300"
                leave-from="opacity-100"
                leave-to="opacity-0"
            >
                <div class="fixed inset-0 bg-gray-900/80" />
            </TransitionChild>

            <div class="fixed inset-0 flex">
                <TransitionChild
                    as="template"
                    enter="transition ease-in-out duration-300 transform"
                    enter-from="-translate-x-full"
                    enter-to="translate-x-0"
                    leave="transition ease-in-out duration-300 transform"
                    leave-from="translate-x-0"
                    leave-to="-translate-x-full"
                >
                    <DialogPanel
                        class="relative mr-16 flex w-full max-w-xs flex-1"
                    >
                        <TransitionChild
                            as="template"
                            enter="ease-in-out duration-300"
                            enter-from="opacity-0"
                            enter-to="opacity-100"
                            leave="ease-in-out duration-300"
                            leave-from="opacity-100"
                            leave-to="opacity-0"
                        >
                            <div
                                class="absolute left-full top-0 flex w-16 justify-center pt-5"
                            >
                                <button
                                    type="button"
                                    class="-m-2.5 p-2.5"
                                    @click="sidebarOpen = false"
                                >
                                    <span class="sr-only">Close sidebar</span>
                                    <XMarkIcon
                                        class="h-6 w-6 text-white"
                                        aria-hidden="true"
                                    />
                                </button>
                            </div>
                        </TransitionChild>
                        <!-- Sidebar component, swap this element with another sidebar if you like -->
                        <div
                            class="flex grow flex-col gap-y-5 overflow-y-auto bg-gray-900 px-6 pb-4 ring-1 ring-white/10"
                        >
                            <div class="flex h-16 shrink-0 items-center">
                                <img
                                    class="h-8 w-auto"
                                    src="https://tailwindui.com/img/logos/mark.svg?color=indigo&shade=500"
                                    alt="Your Company"
                                />
                            </div>
                            <nav class="flex flex-1 flex-col">
                                <ul
                                    role="list"
                                    class="flex flex-1 flex-col gap-y-7"
                                >
                                    <li>
                                        <ul
                                            role="list"
                                            class="-mx-2 space-y-1 hover:cursor-pointer"
                                        >
                                            <li
                                                v-for="item in navigation"
                                                :key="item.name"
                                            >
                                                <router-link
                                                    :to="item.to"
                                                    :class="[
                                                        item.current
                                                            ? 'bg-gray-800 text-white'
                                                            : 'text-gray-400 hover:text-white hover:bg-gray-800',
                                                        'group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold',
                                                    ]"
                                                >
                                                    <component
                                                        :is="item.icon"
                                                        class="h-6 w-6 shrink-0"
                                                        aria-hidden="true"
                                                    />
                                                    {{ item.name }}
                                                </router-link>
                                            </li>
                                        </ul>
                                    </li>
                                    <li>
                                        <div
                                            class="text-xs font-semibold leading-6 text-gray-400"
                                        >
                                            Your teams
                                        </div>
                                        <ul
                                            role="list"
                                            class="-mx-2 mt-2 space-y-1"
                                        >
                                            <li
                                                v-for="team in teams"
                                                :key="team.name"
                                            >
                                                <a
                                                    :href="team.href"
                                                    :class="[
                                                        team.current
                                                            ? 'bg-gray-800 text-white'
                                                            : 'text-gray-400 hover:text-white hover:bg-gray-800',
                                                        'group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold',
                                                    ]"
                                                >
                                                    <span
                                                        class="flex h-6 w-6 shrink-0 items-center justify-center rounded-lg border border-gray-700 bg-gray-800 text-[0.625rem] font-medium text-gray-400 group-hover:text-white"
                                                        >{{
                                                            team.initial
                                                        }}</span
                                                    >
                                                    <span class="truncate">{{
                                                        team.name
                                                    }}</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li class="mt-auto">
                                        <router-link
                                            to=""
                                            class="group -mx-2 flex gap-x-3 rounded-md p-2 text-sm font-semibold leading-6 text-gray-400 hover:bg-gray-800 hover:text-white"
                                        >
                                            <Cog6ToothIcon
                                                class="h-6 w-6 shrink-0"
                                                aria-hidden="true"
                                            />
                                            Settings
                                        </router-link>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                    </DialogPanel>
                </TransitionChild>
            </div>
        </Dialog>
    </TransitionRoot>

    <!-- Static sidebar for desktop -->
    <div
        class="hidden lg:fixed lg:inset-y-0 lg:z-50 lg:flex lg:w-72 lg:flex-col"
    >
        <!-- Sidebar component, swap this element with another sidebar if you like -->
        <div
            class="flex grow flex-col gap-y-5 overflow-y-auto bg-gray-900 px-6 pb-4"
        >
            <div class="flex h-16 shrink-0 items-center">
                <img
                    class="h-8 w-auto"
                    src="https://tailwindui.com/img/logos/mark.svg?color=indigo&shade=500"
                    alt="Your Company"
                />
            </div>
            <nav class="flex flex-1 flex-col">
                <ul role="list" class="flex flex-1 flex-col gap-y-7">
                    <li>
                        <ul
                            role="list"
                            class="-mx-2 space-y-1 hover:cursor-pointer"
                        >
                            <li v-for="item in navigation" :key="item.name">
                                <router-link
                                    :to="item.to"
                                    :class="[
                                        item.current
                                            ? 'bg-gray-800 text-white'
                                            : 'text-gray-400 hover:text-white hover:bg-gray-800',
                                        'group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold',
                                    ]"
                                >
                                    <component
                                        :is="item.icon"
                                        class="h-6 w-6 shrink-0"
                                        aria-hidden="true"
                                    />
                                    {{ item.name }}
                                </router-link>
                            </li>
                        </ul>
                    </li>

                    <li class="mt-auto">
                        <router-link
                            to=""
                            class="group -mx-2 flex gap-x-3 rounded-md p-2 text-sm font-semibold leading-6 text-gray-400 hover:bg-gray-800 hover:text-white"
                        >
                            <Cog6ToothIcon
                                class="h-6 w-6 shrink-0"
                                aria-hidden="true"
                            />
                            Settings
                        </router-link>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
</template>

<script setup name="AuthHeader">
import {
    Dialog,
    DialogPanel,
    TransitionChild,
    TransitionRoot,
} from "@headlessui/vue";
import {
    CalendarIcon,
    ChartPieIcon,
    Cog6ToothIcon,
    DocumentDuplicateIcon,
    FolderIcon,
    HomeIcon,
    UsersIcon,
    XMarkIcon,
} from "@heroicons/vue/24/outline/index.js";
import axios from "axios";
import { onMounted, ref } from "vue";

const fetchData = async () => {
    console.log('kkkk')
    let api_url = import.meta.env.VITE_MIX_API_BASE_URL + "profile";
    // const response = await axios.post(api_url, {

    try {
        const response = await axios.get(api_url, {
            headers: {
                Authorization: `Bearer ${localStorage.getItem("token")}`, // Replace with your actual token
            },
        });
        // data.value = response.data;
        console.log(response);
      
    } catch (error) {
        console.error("Error fetching data:", error);
    }
};

const navigation = [
    {
        name: "Dashboard",
        to: "/dashboard",
        icon: HomeIcon,
        current: true,
        link: "/dashboard",
    },
    {
        name: "Companies",
        to: "/companies",
        icon: UsersIcon,
        current: false,
        link: "/companies",
    },
    // { name: 'Projects', to: '#', icon: FolderIcon, current: false },
    // { name: 'Calendar', to: '#', icon: CalendarIcon, current: false },
    {
        name: "Documents",
        to: "/documents",
        icon: DocumentDuplicateIcon,
        current: false,
        link: "/documents",
    },
    // { name: 'Reports', to: '#', icon: ChartPieIcon, current: false },
];

const sidebarOpen = ref(false);

onMounted(() => {
    fetchData();
});
</script>

<style scoped></style>

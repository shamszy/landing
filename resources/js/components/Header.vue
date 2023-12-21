<template>
    <!-- Header -->
<header>
  <!-- navbar and menu -->
  <nav class="sticky top-0 inset-0 z-10 block h-max fixed w-full max-w-full rounded-none border border-white/80 bg-white bg-opacity-80 py-2 px-4 text-white shadow-md backdrop-blur-2xl backdrop-saturate-200 lg:px-8 lg:py-4">

  <div class="flex justify-between items-center py-6 px-10 container mx-auto">

    <!-- Logo Container -->
    <div class="flex items-center">
                <!-- Logo -->
                <a class="cursor-pointer">
                    <h3 class="text-2xl font-medium text-green-500">
                        <img class="h-10 object-cover"
                            src="https://soundcoregroup.com/wp-content/uploads/2023/12/miremco-logo-nnew.png" alt="MIREMCO Logo">
                    </h3>
                </a>
            </div>

    <div>
      
      <div class="hover:cursor-pointer sm:hidden">
        <spnan class="h-1 rounded-full block w-8 mb-1 bg-gradient-to-tr from-indigo-600 to-green-600"></spnan>
        <spnan class="h-1 rounded-full block w-8 mb-1 bg-gradient-to-tr from-indigo-600 to-green-600"></spnan>
        <spnan class="h-1 rounded-full block w-8 mb-1 bg-gradient-to-tr from-indigo-600 to-green-600"></spnan>
      </div>
      <div class="flex items-center">

        <ul class="sm:flex space-x-4 hidden items-center">
          <li><a href="/" class="text-gray-700 hover:text-indigo-600 text-md ">Home</a></li>
          <li><a href="/about" class="text-gray-700 hover:text-indigo-600 text-md ">About</a></li>
          <li><a href="/contact" class="text-gray-700 hover:text-indigo-600 text-md ">Contact</a></li>
        </ul>

        <div class="md:flex items-center hidden space-x-4 ml-8 lg:ml-12">
          <h1 class="text-gray-700 hover:text-indigo-600 text-md  py-2 hover:cursor-pointer hover:text-indigo-600"><a href="/login">Login</a></h1>
          <h1 class="text-text-gray-600  py-2 hover:cursor-pointer px-4 rounded text-white bg-gradient-to-tr from-green-800 to-green-600 hover:shadow-lg"><a href="/register">REGISTER</a></h1>
        </div>
      </div>
    </div>
  </div>
  </nav>
</header>
</template>
<script setup  name="Nav">
import {Bars3Icon, XMarkIcon} from "@heroicons/vue/24/outline/index.js";

const navigation = [
    { name: 'Home', to: '/' },
    { name: 'About', to: '/about' },
    { name: 'Contact Us', to: '/contact' },
    { name: 'Register', to: '/register' },
]
</script>

<style scoped>

</style>

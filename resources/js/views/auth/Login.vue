<template>
<div class="flex h-screen w-full items-center justify-center bg-gray-100">
  <div class="w-full max-w-3xl overflow-hidden rounded-lg bg-white shadow-lg sm:flex">
    <div class="m-2 w-full rounded-2xl bg-gray-400 bg-cover bg-center text-white sm:w-2/5" style="background-image: url('https://plus.unsplash.com/premium_photo-1682144351190-9034a7c3b3a8?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D')"></div>
    <div class="w-full sm:w-3/5">
      <div class="p-8">
        <h1 class="text-3xl font-black text-slate-700">Sign-in</h1>
        <p class="mt-2 mb-5 text-base leading-tight text-gray-600">Sign-in an account to get access</p>
        <form class="mt-8">
          <div class="relative mt-2 w-full">
            <input type="text" id="email" class="border-1 peer block w-full appearance-none rounded-lg border border-gray-300 bg-transparent px-2.5 pb-2.5 pt-4 text-sm text-gray-900 focus:border-blue-600 focus:outline-none focus:ring-0" placeholder=" " />
            <label for="email" class="absolute top-2 left-1 z-10 origin-[0] -translate-y-4 scale-75 transform cursor-text select-none bg-white px-2 text-sm text-gray-500 duration-300 peer-placeholder-shown:top-1/2 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:scale-100 peer-focus:top-2 peer-focus:-translate-y-4 peer-focus:scale-75 peer-focus:px-2 peer-focus:text-blue-600"> Enter Your Email </label>
          </div>
          <div class="relative mt-2 w-full">
            <input type="text" id="password" class="border-1 peer block w-full appearance-none rounded-lg border border-gray-300 bg-transparent px-2.5 pb-2.5 pt-4 text-sm text-gray-900 focus:border-blue-600 focus:outline-none focus:ring-0" placeholder=" " />
            <label for="password" class="absolute top-2 left-1 z-10 origin-[0] -translate-y-4 scale-75 transform cursor-text select-none bg-white px-2 text-sm text-gray-500 duration-300 peer-placeholder-shown:top-1/2 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:scale-100 peer-focus:top-2 peer-focus:-translate-y-4 peer-focus:scale-75 peer-focus:px-2 peer-focus:text-blue-600"> Enter Your Password</label>
          </div>
          <input class="mt-4 w-full cursor-pointer rounded-lg bg-green-700 pt-3 pb-3 text-white shadow-lg hover:bg-green-500" type="submit" value="Sign in" />
        </form>
        <div class="mt-4 text-center">
          <p class="text-sm text-gray-600">Don't have an account? <a href="/register" class="font-bold text-green-600 no-underline hover:text-green-400">Sign up</a></p>
        </div>
      </div>
    </div>
  </div>
</div>
</template>

<!-- Footer -->
<Footer />
<!-- End of Footer -->

<script>
import {ref} from "vue";
import store from "../../store";
import router from "../../router";
import axios from "axios";

export default {
    name: "Login",
    setup() {
        const user = ref({
            email : '',
            password : ''
        });
        const logIn = async  () => {
            const notify = () => {
                toast("Akpos", {
                    autoClose: 1000,
                }); // ToastOptions
            }
            console.log('kkkkk')
            let api_url = import.meta.env.VITE_MIX_API_BASE_URL + 'login'
            console.log(api_url)
            try {
                const response = await axios.post(api_url, {
                    email: user.value.email,
                    password: user.value.password
                })
                localStorage.setItem(
                    "token",
                    response.data.token
                );
                await store.dispatch("user", response.data.user);
                await router.push("/dashboard");
            } catch (e) {
                console.log(e.response)
            }
        }
        return {user, logIn}
    }
}
</script>

<style scoped>

</style>

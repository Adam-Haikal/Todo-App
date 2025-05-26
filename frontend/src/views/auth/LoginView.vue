<script setup>
import { useUserStore } from "@/stores/user";
import { ref } from "vue";
import Input from "@/components/Input.vue";
import Button from "@/components/Button.vue";

const userStore = useUserStore();
userStore.clearErrors();
const formData = ref({
  email: "",
  password: "",
});
</script>

<template>
  <div>
    <h2
      class="mt-10 text-center text-2xl/9 font-bold tracking-tight text-gray-900">
      Sign in to your account
    </h2>

    <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">
      <!-- loop through all the errors from userStore and display errors -->
      <div v-if="userStore.hasErrors">
        <ul class="text-red-600 bg-red-100 p-4 rounded-md my-2">
          <li v-for="(error, index) in userStore.errors" :key="index">
            <p v-for="(message, i) in error" :key="i" class="text-center">{{ message }}</p>
          </li>
        </ul>
      </div>

      <form class="space-y-4" @submit.prevent="userStore.login(formData)">
        <div>
          <Input input-type="email" required v-model="formData.email" />
          <Input input-type="password" required v-model="formData.password" />
        </div>

        <p class="mt-4 text-center text-sm/6 text-gray-500">
          Don't have an account?
          <router-link
            :to="{ name: 'Register' }"
            class="text-sm font-semibold text-indigo-600 hover:text-indigo-500">
            Create an account
          </router-link>
        </p>

        <Button type="submit">Login</Button>
      </form>
    </div>
  </div>
</template>

<script setup>
import { useUserStore } from "@/stores/user";
import { ref } from "vue";
import Input from "@/components/Input.vue";
import Button from "@/components/Button.vue";

const userStore = useUserStore();
userStore.clearErrors();
const formData = ref({
  name: "",
  email: "",
  password: "",
  password_confirmation: "",
});
</script>

<template>
  <div>
    <h2
      class="mt-10 text-center text-2xl/9 font-bold tracking-tight text-gray-900">
      Create new account
    </h2>

    <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">
      <!-- loop through all the errors from userStore and display errors -->
      <div v-if="userStore.hasErrors">
        <ul class="text-red-600 bg-red-100 p-4 rounded-md my-2">
          <li v-for="(error, index) in userStore.errors" :key="index">
            <p v-for="(message, i) in error" :key="i" class="text-center">
              {{ message }}
            </p>
          </li>
        </ul>
      </div>

      <form class="space-y-4" @submit.prevent="userStore.register(formData)">
        <div>
          <Input input-type="name" required v-model="formData.name" />
          <Input input-type="email" required v-model="formData.email" />
          <Input input-type="password" required v-model="formData.password" />
          <Input
            input-type="password-confirmation"
            required
            v-model="formData.password_confirmation" />
        </div>

        <p class="mt-4 text-center text-sm/6 text-gray-500">
          Already have an account?
          <router-link
            :to="{ name: 'Login' }"
            class="font-semibold text-indigo-600 hover:text-indigo-500">
            Go to login
          </router-link>

          
        </p>

        <Button
          type="submit"
          class="w-full bg-indigo-600 hover:bg-indigo-500 text-white py-2">
          Register
        </Button>
      </form>
    </div>
  </div>
</template>

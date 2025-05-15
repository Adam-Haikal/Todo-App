<script setup>
import GuestLayout from "@/components/GuestLayout.vue";
import Input from "@/components/Input.vue";
import Button from "@/components/Button.vue";
</script>

<template>
  <GuestLayout>
    <h2
      class="mt-10 text-center text-2xl/9 font-bold tracking-tight text-gray-900">
      Create new account
    </h2>

    <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">
      <form
        class="space-y-4"
        action="#"
        method="POST"
        @submit.prevent="register">
        <div>
          <Input input-type="name" required />
          <Input input-type="email" required />
          <Input input-type="password" required />
          <Input input-type="password-confirmation" required />
        </div>

        <p class="mt-4 text-center text-sm/6 text-gray-500">
          Already have an account?
          <router-link
            :to="{ name: 'Login' }"
            class="font-semibold text-indigo-600 hover:text-indigo-500">
            Go to login
          </router-link>

          <router-link
            to="{ name: 'ForgotPassword' }"
            class="flex justify-center font-semibold text-indigo-600 hover:text-indigo-500">
            Forgot password
          </router-link>
        </p>

        <Button type="submit">Register</Button>
      </form>
    </div>
  </GuestLayout>
</template>

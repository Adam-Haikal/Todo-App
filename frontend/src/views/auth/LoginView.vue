<script setup>
import GuestLayout from "@/components/GuestLayout.vue";
import Input from "@/components/Input.vue";
import Button from "@/components/Button.vue";
</script>

<template>
  <div>
    <h2
      class="mt-10 text-center text-2xl/9 font-bold tracking-tight text-gray-900">
      Sign in to your account
    </h2>

    <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">
      <form class="space-y-4" action="#" method="POST">
        <div>
          <Input input-type="email" required />
          <Input input-type="password" required />
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

<script setup>
import { MenuItem } from "@headlessui/vue";
</script>

<template>
  <MenuItem v-slot="{ active }">
    <h2
      :class="[
        active ? 'bg-gray-100 outline-hidden' : '',
        'block px-4 py-2 text-sm text-gray-700 z-10 ',
      ]">
      <slot />
    </h2>
  </MenuItem>
</template>

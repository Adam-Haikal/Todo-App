<script setup>
import { Menu, MenuButton, MenuItems } from "@headlessui/vue";

defineProps({
  elapsed: {
    type: Boolean,
    default: false,
  },
});
</script>

<template>
  <!-- If it is user icon then show when on big screen else hidden,
        If elapsed then show else hidden (must be displayed on all screen sizes) -->
  <div :class="[!elapsed ? 'hidden' : '', ' md:block']">
    <div class="flex items-center">
      <Menu as="div" class="relative">
        <div>
          <!-- Icon -->
          <MenuButton
            class="relative flex max-w-xs items-center rounded-full focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-gray-800 focus:outline-hidden">
            <span class="absolute -inset-1.5" />
            <slot name="menuIcon" />
          </MenuButton>
        </div>

        <transition
          enter-active-class="transition ease-out duration-100"
          enter-from-class="transform opacity-0 scale-95"
          enter-to-class="transform opacity-100 scale-100"
          leave-active-class="transition ease-in duration-75"
          leave-from-class="transform opacity-100 scale-100"
          leave-to-class="transform opacity-0 scale-95">
          <!-- Dropdown menu items -->
          <MenuItems
            class="absolute right-0 z-10 mt-0 w-48 origin-top-right rounded-md bg-white py-1 shadow-lg ring-1 ring-black/5 focus:outline-hidden">
            <slot />
          </MenuItems>
        </transition>
      </Menu>
    </div>
  </div>
</template>

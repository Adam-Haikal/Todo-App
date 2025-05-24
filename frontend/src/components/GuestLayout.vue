<script setup>
import { ClipboardDocumentListIcon } from "@heroicons/vue/24/outline";
</script>

<template>
  <div
    class="flex min-h-full flex-1 flex-col justify-center px-6 py-12 lg:px-8">
    <div class="sm:mx-auto sm:w-full sm:max-w-sm">
      <ClipboardDocumentListIcon
        class="mx-auto size-10 text-indigo-600"
        alt="TodoApp" />
    </div>

<<<<<<< Updated upstream
    <!-- {{ inputValue }} -->

    <slot />
=======
    <!-- <slot /> -->
    <RouterView />
>>>>>>> Stashed changes
  </div>
</template>

<script setup>
import { useTagStore } from "@/stores/tag";
import { onMounted } from "vue";

const tagStore = useTagStore();

onMounted(async () => {
  try {
    await tagStore.getTags();
  } catch (error) {
    console.error("Error fetching tags:", error);
  }
});
</script>

<template>
  <main class="relative mx-auto sm:max-w-9/10 px-4 py-6 sm:px-6 lg:px-8">
    <p class="text-2xl font-bold mb-4">Tags</p>
    <!-- show tags as pills -->
    <div class="flex flex-wrap gap-2">
      <span
        v-for="tag in tagStore.tags"
        :key="tag"
        :style="{ backgroundColor: tag.color }"
        class="text-sm text-white font-medium px-4 py-2 rounded-full">
        {{ tag.name }}
      </span>
    </div>
  </main>
</template>

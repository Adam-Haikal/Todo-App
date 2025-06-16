<script setup>
import { onMounted } from "vue";
import { useRoute } from "vue-router";
import { useTagStore } from "@/stores/tag";
import { useUserStore } from "@/stores/user";
import Header from "@/components/Header.vue";

const route = useRoute();

const tagStore = useTagStore();
const userStore = useUserStore();

const taskId = route.params.id;

onMounted(async () => {
  try {
    await tagStore.getTags();
  } catch (error) {
    console.error("Error fetching tags:", error);
  }
});
</script>

<template>
  <div>
    <Header
      title="Tags"
      :taskId="taskId"
      hasForm
      dataType="tag"
      subtitle="Enter tag name" />

    <main class="relative mx-auto sm:max-w-9/10 px-4 py-6 sm:px-6 lg:px-8">
      <!-- show tags as pills -->
      <div class="flex flex-wrap gap-2">
        <span
          v-for="tag in tagStore.tags"
          :key="tag"
          :style="{ backgroundColor: tag.color }"
          class="text-sm text-white font-medium px-4 py-2 rounded-full">
          {{ tag.name }}
          <span class="">
            <!-- Check if the owner of the tag is the current user -->
            <span
              v-if="tag.user_id === userStore.user.id"
              @click="tagStore.deleteTag(tag.id)"
              class="cursor-pointer ml-1">
              X
            </span>
          </span>
        </span>

        <!-- no tags -->
        <p v-if="!tagStore.hasTags">No tags yet</p>
      </div>
    </main>
  </div>
</template>

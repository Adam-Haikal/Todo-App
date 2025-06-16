<script setup>
import { onMounted, ref } from "vue";
import { useTagStore } from "@/stores/tag";
import { useUserStore } from "@/stores/user";
import { toastCreated } from "@/composables/toastCreated";
import Header from "@/components/Header.vue";
import contrast from "color-contrast";
import { HalfCircleSpinner } from "epic-spinners";

const tagStore = useTagStore();
const userStore = useUserStore();

const headerRef = ref(null);
const isLoading = ref(false);
const props = defineProps({
  taskId: {
    type: String,
    required: false,
  },
});

/* Get text color based on background color */
const getTextColor = (backgroundColor) => {
  const textColor = "#fff"; // default text color
  const contrastRatio = contrast(backgroundColor, textColor);
  /* threshold for readable contrast */
  if (contrastRatio < 4.5) {
    return "#000"; /* change text color to black if contrast is too low */
  }
  return textColor;
};

const handleSubmit = async (formData) => {
  await tagStore.createTag({
    name: formData.name,
    color: formData.color,
    task_id: props.taskId,
  });

  /* Call handleCancel directly */
  headerRef.value.handleCancel();
};

onMounted(async () => {
  isLoading.value = true;
  try {
    await tagStore.getTags();
  } catch (error) {
    console.error("Error fetching tags:", error);
  }
  isLoading.value = false;
});
</script>

<template>
  <div>
    <Header
      title="Tags"
      dataType="tag"
      subtitle="Enter tag name"
      :handleSubmit="handleSubmit"
      ref="headerRef" />

    <main class="relative mx-auto sm:max-w-9/10 px-4 py-6 sm:px-6 lg:px-8">
      <!-- show tags as pills -->
      <div class="flex flex-wrap gap-2">
        <span
          v-for="tag in tagStore.tags"
          :key="tag"
          :style="{
            backgroundColor: tag.color,
            color: getTextColor(tag.color),
          }"
          class="text-sm font-medium px-4 py-2 rounded-full">
          {{ tag.name }}

          <!-- Check if the owner of the tag is the current user -->
          <span
            v-if="tag.user_id === userStore.user.id"
            @click="tagStore.deleteTag(tag.id, tag.name)"
            class="cursor-pointer ml-1">
            X
          </span>
        </span>

        <!-- Display no subtasks message -->
        <div
          class="absolute top-[250px] left-1/2 transform -translate-x-1/2 -translate-y-1/2 -z-10">
          <HalfCircleSpinner
            v-if="isLoading"
            :animation-duration="1000"
            :size="60"
            :color="'#1e2939'" />
          <p v-if="!tagStore.hasTags && !isLoading">No tags available.</p>
        </div>
      </div>
    </main>
  </div>
</template>

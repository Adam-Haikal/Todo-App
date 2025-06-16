<script setup>
import { onMounted, ref } from "vue";
import { useTagStore } from "@/stores/tag";
import { useUserStore } from "@/stores/user";
import { toastCreated } from "@/composables/toastCreated";
import Header from "@/components/Header.vue";
import contrast from "color-contrast";

const tagStore = useTagStore();
const userStore = useUserStore();

const headerRef = ref(null);
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
  toastCreated(formData);

  /* Call handleCancel directly */
  headerRef.value.handleCancel();
  /* Reset taskData.color to a default value */
  formData.color = "#ffffff";
};

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
          <span>
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

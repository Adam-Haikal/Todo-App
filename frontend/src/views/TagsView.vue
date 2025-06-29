<script setup>
import { onMounted, ref } from "vue";
import { useTagStore } from "@/stores/tag";
import { useUserStore } from "@/stores/user";
import { colorContrast } from "@/composables/colorContrast";
import Header from "@/components/Header.vue";
import TagItems from "@/components/TagItems.vue";
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
      <TagItems
        :tagItem="tagStore"
        class="h-full w-full min-h-full min-w-full relative overflow-y-visible"
        pillClass="text-sm font-medium px-4 py-2"
        :handleRemoveTag="tagStore.deleteTag" />
      <div class="flex flex-wrap gap-2">

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

<script setup>
import { computed, onMounted, ref } from "vue";
import { useTaskStore } from "@/stores/task";
import { useTagStore } from "@/stores/tag";
import CardItem from "@/components/CardItem.vue";
import Header from "@/components/Header.vue";
import DropdownMenu from "@/components/DropdownMenu.vue";
import { BarsArrowDownIcon } from "@heroicons/vue/24/outline";
import { HalfCircleSpinner } from "epic-spinners";
import dayjs from "dayjs";

const taskStore = useTaskStore();
const tagStore = useTagStore();

const isLoading = ref(false);
const headerRef = ref(null);
const cardItemRef = ref(null);
const selectedTagId = ref(null);

const selectedTag = computed(() =>
  tagStore.tags.find((tag) => tag.id === selectedTagId.value)
);
const filteredTasks = computed(() => {
  if (!selectedTagId.value) return taskStore.tasks;
  return taskStore.tasks.filter((task) =>
    (task.tags || []).some((tag) => tag.id === selectedTagId.value)
  );
});

const handleSubmit = async (formData) => {
  await taskStore.createTask(formData);
  /* Call handleCancel directly */
  headerRef.value.handleCancel();
};

const handleUpdate = async (formData, index) => {
  formData.original_name = formData.name;
  formData.updated_at = dayjs().toISOString();

  await taskStore.updateTask(formData);
  /* Call handleCancel directly */
  cardItemRef.value[index].handleCancel(formData.id);
};

const handleDelete = async (taskItem) => {
  await taskStore.deleteTask(taskItem);
};

onMounted(async () => {
  isLoading.value = true;
  taskStore.tasks = [];
  try {
    await taskStore.getTasks();
  } catch (error) {
    console.error("Error fetching tasks:", error);
  }
  isLoading.value = false;
});
</script>

<template>
  <div>
    <Header
      title="Tasks"
      subtitle="Enter task name"
      :handleSubmit="handleSubmit"
      ref="headerRef" />

    <!-- Display tasks -->
    <main>
      <section class="relative mx-auto sm:max-w-9/10 px-4 py-6 sm:px-6 lg:px-8">
        <table class="min-w-full divide-y divide-gray-200">
          <thead>
            <tr>
              <th
                scope="col"
                class="px-6 pr-8 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                Task Name
              </th>
              <th
                scope="col"
                class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                Status
              </th>
              <th
                scope="col"
                class="flex px-0 pl-10 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                Tags

                <!-- Filter by tag dropdown -->
                <DropdownMenu>
                  <template #menuIcon>
                    <BarsArrowDownIcon class="size-4 mx-2" />
                  </template>

                  <template #default>
                    <p>Filter By</p>
                    <select
                      v-model="selectedTagId"
                      class="border rounded p-1"
                      placeholder="Select a tag">
                      <option value="">All</option>
                      <option
                        v-for="tag in tagStore.tags"
                        :key="tag.id"
                        :value="tag.id">
                        {{ tag.name }}
                      </option>
                    </select>
                  </template>
                </DropdownMenu>
              </th>
            </tr>
          </thead>
        </table>

        <CardItem
          v-for="(task, index) in filteredTasks"
          :key="task.id"
          :tasksItem="task"
          :handleUpdate="(formData) => handleUpdate(formData, index)"
          :handleDelete="handleDelete"
          :handleRemoveTag="tagStore.removeTagFromTask"
          ref="cardItemRef" />

        <!-- Display no tasks message -->
        <div
          class="absolute top-[250px] left-1/2 transform -translate-x-1/2 -translate-y-1/2 -z-10">
          <HalfCircleSpinner
            v-if="isLoading"
            :animation-duration="1000"
            :size="60"
            :color="'#1e2939'" />
          <p v-if="!taskStore.hasTasks && !isLoading">No tasks available.</p>
          <p v-if="filteredTasks.length === 0 && !isLoading && selectedTag">
            No tasks available for {{ selectedTag.name }}
          </p>
        </div>

        <!-- Pagination links -->
      </section>
    </main>
  </div>
</template>

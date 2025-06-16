<script setup>
import { onMounted, ref } from "vue";
import { useTaskStore } from "@/stores/task";
import CardItem from "@/components/CardItem.vue";
import Header from "@/components/Header.vue";
import { HalfCircleSpinner } from "epic-spinners";
import dayjs from "dayjs";

const taskStore = useTaskStore();

const isLoading = ref(false);
const headerRef = ref(null);
const cardItemRef = ref(null);

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
        <CardItem
          v-for="(task, index) in taskStore.tasks"
          :key="task.id"
          :tasksItem="task"
          :handleUpdate="(formData) => handleUpdate(formData, index)"
          :handleDelete="handleDelete"
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
        </div>

        <!-- Pagination links -->
      </section>
    </main>
  </div>
</template>

<script setup>
import { onMounted, ref } from "vue";
import { useTaskStore } from "@/stores/task";
import CardItem from "@/components/CardItem.vue";
import Header from "@/components/Header.vue";
import { HalfCircleSpinner } from "epic-spinners";

// Import the task store
const taskStore = useTaskStore();

const isLoading = ref(false);

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
    <Header title="Tasks" hasForm />

    <!-- Display tasks -->
    <main>
      <section class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
        <CardItem
          v-for="task in taskStore.tasks"
          :key="task.id"
          :tasksItem="task" />

        <!-- Display no tasks message -->
        <div
          class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2">
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

<script setup>
import { onMounted, ref } from "vue";
import { useTaskStore } from "@/stores/task";
import CardItem from "@/components/CardItem.vue";
import Header from "@/components/Header.vue";
import Loading from "vue-loading-overlay";

// Import the task store
const taskStore = useTaskStore();

const isLoading = ref(false);

onMounted(async () => {
  isLoading.value = true;
  try {
    taskStore.tasks = [];
    await taskStore.getTasks();
  } catch (error) {
    console.error("Error fetching tasks:", error);
  }
  isLoading.value = false;
});
</script>

<template>
  <div>
    <Header hasForm />

    <!-- Display tasks -->
    <main>
      <section class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
        <CardItem
          v-for="task in taskStore.tasks"
          :key="task.id"
          :tasksItem="task" />

        <!-- Display no tasks message -->
        <Loading :active="isLoading" color="#1e2939" />
        <p
          v-if="!taskStore.hasTasks && !isLoading"
          class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2">
          No tasks available.
        </p>

        <!-- Pagination links -->
      </section>
    </main>
  </div>
</template>

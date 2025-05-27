<script setup>
import { onMounted, watch } from "vue";
import { RouterLink } from "vue-router";
import { useTaskStore } from "@/stores/task";
import CardItem from "@/components/CardItem.vue";
import Header from "@/components/Header.vue";

// Import the task store
const taskStore = useTaskStore();

onMounted(async () => {
  try {
    await taskStore.getTasks();
  } catch (error) {
    console.error("Error fetching tasks:", error);
  }
});
</script>

<template>
  <div>
    <Header hasForm />
    <!-- Display tasks -->
    <main>
      <section class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
        <!-- <RouterLink
          v-for="task in taskStore.tasks"
          :key="task.id"
          :to="{ name: 'Subtasks', params: { id: task.id } }"
          class="gap-1 grid">
          <CardItem :tasksItem="task" />
        </RouterLink> -->

        <CardItem
          v-for="task in taskStore.tasks"
          :key="task.id"
          :tasksItem="task" />

        <p v-if="!taskStore.hasTasks">No tasks available.</p>

        <!-- Pagination links -->
      </section>
    </main>
  </div>
</template>

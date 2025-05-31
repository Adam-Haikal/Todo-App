<script setup>
import { onMounted, ref } from "vue";
import axiosClient from "@/axios";
import { useRoute } from "vue-router";
import { useSubtaskStore } from "@/stores/subtask";
import CardItem from "@/components/CardItem.vue";
import Header from "@/components/Header.vue";

const route = useRoute();
const subtaskStore = useSubtaskStore();

const taskId = route.params.id;

onMounted(async () => {
  try {
    await subtaskStore.getSubtasks(taskId);
  } catch (error) {
    console.error("Error fetching subtasks:", error);
  }
});
</script>

<template>
  <div>
    <Header title="Subtasks" :taskId="taskId" hasForm isSubtask />

    <!-- Display tasks -->
    <main>
      <section class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
        <CardItem
          v-for="subtask in subtaskStore.subtasks"
          :key="subtask.id"
          :tasksItem="subtask"
          isSubtask />

        <p v-if="!subtaskStore.hasSubtasks">No subtasks available.</p>
      </section>
    </main>
  </div>
</template>

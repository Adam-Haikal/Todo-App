<script setup>
import { onMounted, ref } from "vue";
import axiosClient from "@/axios";
import { useRoute } from "vue-router";
import { useSubtaskStore } from "@/stores/subtask";
import Header from "@/components/Header.vue";
import CardItem from "@/components/CardItem.vue";
import ItemCount from "@/components/ItemCount.vue";

const route = useRoute();
const subtaskStore = useSubtaskStore();

const taskId = route.params.id;

onMounted(async () => {
  try {
    subtaskStore.subtasks = [];
    await subtaskStore.getSubtasks(taskId);
  } catch (error) {
    console.error("Error fetching subtasks:", error);
  }
});
</script>

<template>
  <div>
    <Header title="Subtasks" :taskId="taskId" hasForm isSubtask />

    <main>
      <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
        <div v-if="subtaskStore.hasSubtasks" class="space-y-6">
          <!-- Display ongoing subtasks -->
          <section>
            <p class="mb-1">
              Ongoing subtasks
              <ItemCount>{{ subtaskStore.ongoingTasks.length }}</ItemCount>
            </p>
            <CardItem
              v-for="subtask in subtaskStore.ongoingTasks"
              :key="subtask.id"
              :tasksItem="subtask"
              isSubtask />
          </section>

          <!-- Display completed subtasks -->
          <section>
            <p class="mb-1">
              Completed subtasks
              <ItemCount>{{ subtaskStore.completedTasks.length }}</ItemCount>
            </p>
            <CardItem
              v-for="subtask in subtaskStore.completedTasks"
              :key="subtask.id"
              :tasksItem="subtask"
              isSubtask />
          </section>
        </div>

        <p v-if="!subtaskStore.hasSubtasks">No subtasks available.</p>
      </div>
    </main>
  </div>
</template>

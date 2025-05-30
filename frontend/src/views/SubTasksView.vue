<script setup>
import { onMounted, ref } from "vue";
import axiosClient from "@/axios";
import { useRoute } from "vue-router";
import { useSubtaskStore } from "@/stores/subtask";
import CardItem from "@/components/CardItem.vue";
import Header from "@/components/Header.vue";

const route = useRoute();
const subtaskStore = useSubtaskStore();

// const taskId = route.params.id;

// const submit = async () => {
//   try {
//     if (!newTask.value.name.trim()) {
//       console.error("Task name is required");
//       return;
//     }
//     const formData = new FormData();
//     formData.append("task_id", taskId);
//     formData.append("name", newTask.value.name);
//     formData.append("completed", Number(newTask.value.completed));

//     const response = await axiosClient.post(
//       `/api/subtasks/${taskId}`,
//       formData
//     );
//     /* Handle the response data */
//     tasks.value.push(
//       response.data
//     ); /* <--- Update the tasks array with the new subtask data */

//     showCreateForm.value = false;
//   } catch (error) {
//     console.error("Error creating task", error);
//   }
// };

onMounted(async () => {
  try {
    const subtaskId = route.params.id;
    await subtaskStore.getSubtasks(subtaskId);
  } catch (error) {
    console.error("Error fetching subtasks:", error);
  }
});
</script>

<template>
  <div>
    <Header title="Subtasks" hasForm isSubtask />

    <!-- Display tasks -->
    <main>
      <section class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
        <CardItem
          v-for="subtask in subtaskStore.subtasks"
          :key="subtask.id"
          :tasksItem="subtask"
          isSubtask />

        <p v-if="!subtaskStore.hasTasks">No subtasks available.</p>
      </section>
    </main>
  </div>
</template>

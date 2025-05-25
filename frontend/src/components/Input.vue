<script setup>
import { defineModel } from "vue";

const data = defineModel(); // replaces modelValue + update:modelValue
const props = defineProps({
  inputType: String,
});

const emit = defineEmits(["update:modelValue"]);

const inputMappings = {
  name: {
    type: "text",
    name: "fullName",
    id: "name",
    autocomplete: "name",
    placeholder: "Full Name",
  },
  email: {
    type: "email",
    name: "email",
    id: "email",
    autocomplete: "email",
    placeholder: "Email Address",
  },
  password: {
    type: "password",
    name: "password",
    id: "password",
    autocomplete: "current-password",
    placeholder: "Password",
  },
  "password-confirmation": {
    type: "password",
    name: "password_confirmation",
    id: "passwordConfirmation",
    autocomplete: "new-password",
    placeholder: "Confirm Password",
  },
  checkbox: {
    type: "checkbox",
    name: "completed",
    id: "completed",
  },
  text: {
    type: "text",
    name: "taskName",
    id: "taskName",
    placeholder: "Enter Task Name",
  },
};

// Check if the inputType exists in the inputMappings object and return the corresponding attributes
const inputAttrs = inputMappings[props.inputType] || {};
</script>

<template>
  <input
    :="inputAttrs"
    v-model="data"
    class="first:rounded-t-md last:rounded-b-md block w-full bg-white px-3 py-2 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6" />
</template>

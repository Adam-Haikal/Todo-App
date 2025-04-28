// Update Form Elements
const editButtons = document.querySelectorAll('[name="edit-button"]'); // Edit buttons
const updateForm = document.getElementById("updateForm");
const taskIdField = document.getElementById("updateTaskId");
const taskNameField = document.getElementById("updateTaskName");
const taskDescriptionField = document.getElementById("updateTaskDescription");
const taskCheckbox = document.getElementById("updateTaskCheckbox");
const closeUpdateFormButton = document.getElementById("closeUpdateFormButton"); // Close button for update form

// Handle Edit Button Clicks
editButtons.forEach((button) => {
    button.addEventListener("click", () => {
        const task = JSON.parse(button.getAttribute("data-task"));

        // Populate the update form with task data
        taskIdField.value = task.id;
        taskNameField.value = task.task_name;
        taskDescriptionField.value = task.description;
        taskCheckbox.checked = task.is_completed;

        // Set task name in title
        const taskTitle = document.getElementById("updateTaskTitle");
        taskTitle.textContent = task.task_name;

        // Show the form and overlay
        updateForm.classList.remove("hidden");
        overlay.classList.remove("hidden");
    });
});

// Close Update Form
if (closeUpdateFormButton) {
    closeUpdateFormButton.addEventListener("click", () => {
        updateForm.classList.add("hidden");
        overlay.classList.add("hidden");
    });
}

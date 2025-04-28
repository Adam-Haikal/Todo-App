document.addEventListener("DOMContentLoaded", () => {
    const editButtons = document.querySelectorAll('[name="edit-button"]'); // Edit buttons
    const updateForm = document.getElementById("updateForm");
    const listNameField = document.getElementById("updateListName");
    
    const closeUpdateFormButton = document.getElementById("closeUpdateFormButton");
    const overlay = document.getElementById("overlay");

    // Handle Edit Button Clicks
    editButtons.forEach((button) => {
        button.addEventListener("click", () => {
            const list = JSON.parse(button.getAttribute("data-list"));

            // Populate the update form with list data
            listNameField.value = list.list_name;
            updateForm.action = `/tasks/${list.id}`;

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
});
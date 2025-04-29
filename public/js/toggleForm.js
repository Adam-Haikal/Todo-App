document.addEventListener("DOMContentLoaded", () => {
    const overlay = document.getElementById("overlay");

    // Create Form Elements
    const createForm = document.getElementById("createForm");
    const showCreateFormButton = document.querySelectorAll(
        '[name="showFormButtons"]'
    ); // Button to show create form
    const closeCreateFormButton = document.getElementById(
        "closeCreateFormButton"
    ); // Close button for create form

    // Show Create Form
    if (showCreateFormButton) {
        showCreateFormButton.forEach((button) => {
            button.addEventListener("click", () => {
                createForm.classList.remove("hidden");
                overlay.classList.remove("hidden");
            });
        });
    }

    // Close Create Form
    if (closeCreateFormButton) {
        closeCreateFormButton.addEventListener("click", () => {
            createForm.classList.add("hidden");
            overlay.classList.add("hidden");
        });
    }

    // Close any form when clicking outside
    overlay.addEventListener("click", () => {
        if (createForm && !createForm.classList.contains("hidden")) {
            createForm.classList.add("hidden");
        }
        if (updateForm && !updateForm.classList.contains("hidden")) {
            updateForm.classList.add("hidden");
        }
        overlay.classList.add("hidden");
    });
});

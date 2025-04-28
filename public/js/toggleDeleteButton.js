document.addEventListener("DOMContentLoaded", function () {
    const ShowDeleteModeButton = document.getElementById(
        "ShowDeleteModeButton"
    );
    const deleteButton = document.getElementById("deleteButton");
    const closeDeleteModeButton = document.getElementById(
        "closeDeleteModeButton"
    );
    const deleteCheckboxes = document.querySelectorAll([
        'input[name^="delete_task_ids[]"]',
        'input[name^="delete_list_ids[]"]',
    ]);

    // Hide delete button and checkboxes when "Delete Tasks" button is clicked
    const hideDeleteMode = () => {
        ShowDeleteModeButton.classList.remove("hidden"); // Hide delete button
        deleteButton.classList.add("hidden"); // Hide delete button
        closeDeleteModeButton.classList.add("hidden"); // Hide close button
        deleteCheckboxes.forEach((checkbox) => {
            checkbox.classList.add("hidden"); // Hide checkboxes
        });
    };

    // Show delete button and checkboxes when "Delete Tasks" button is clicked
    const showDeleteMode = () => {
        ShowDeleteModeButton.classList.add("hidden"); // Show delete button
        deleteButton.classList.remove("hidden"); // Show delete button
        closeDeleteModeButton.classList.remove("hidden"); // Show close button
        deleteCheckboxes.forEach((checkbox) => {
            checkbox.classList.remove("hidden"); // Show checkboxes
        });
    };
    ShowDeleteModeButton.addEventListener("click", showDeleteMode);
    closeDeleteModeButton.addEventListener("click", hideDeleteMode);
});

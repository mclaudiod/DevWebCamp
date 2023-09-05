(function() {
    const tagsInput = document.querySelector("#tags-input");

    if(tagsInput) {

        const tagsDiv = document.querySelector("#tags");
        const tagsHiddenInput = document.querySelector("[name='tags']");

        let tags = [];

        // Recover from the hidden input

        if(tagsHiddenInput.value !== "") {
            tags = tagsHiddenInput.value.split(",");
            showTags();
        }

        // Listen the changes in the input

        tagsInput.addEventListener("keypress", saveTag);

        function saveTag(e) {

            // This means every time you write a comma in the input

            if(e.keyCode === 44) {

                // We check if the input is empty or just with spaces so we don't save that

                if(e.target.value.trim() === "" || e.target.value < 1) {
                    return;
                }

                // Prevents the comma of being written in the input so they don't acumulate, and they don't get saved either, then we add the tag to the tags array along with the ones that were there before while cleaning blank spaces, and finally we clean the input proper

                e.preventDefault();
                tags = [...tags, e.target.value.trim()];
                tagsInput.value = "";

                showTags();
            }
        }

        function showTags() {
            tagsDiv.textContent = "";
            tags.forEach(tag => {
                const label = document.createElement("LI");
                label.classList.add("form__tag");
                label.textContent = tag;
                label.ondblclick = deleteTag;
                tagsDiv.appendChild(label);
            })

            updateHiddenInput();
        }

        function deleteTag(e) {
            e.target.remove();

            // Returns an array with every tag except the one we double clicked on

            tags = tags.filter(tag => tag !== e.target.textContent);
            updateHiddenInput();
        }

        function updateHiddenInput() {
            tagsHiddenInput.value = tags.toString();
        }
    }
})();
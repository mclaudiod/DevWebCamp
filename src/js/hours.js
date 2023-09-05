(function() {
    const hours = document.querySelector("#hours");

    if(hours) {
        const categorie = document.querySelector('[name="categorie_id"]');
        const days = document.querySelectorAll('[name="day"]');
        const inputHiddenDay = document.querySelector('[name="day_id"]');
        const inputHiddenHour = document.querySelector('[name="hour_id"]');
        
        categorie.addEventListener("change", searchTerm);
        days.forEach(day => day.addEventListener("change", searchTerm));

        let search = {
            categorie_id: +categorie.value || "",
            day: +inputHiddenDay.value || ""
        };

        if(!Object.values(search).includes("")) {
            (async () => {
                await searchEvents();

                // Highlight the current hour

                const id = inputHiddenHour.value;
                const selectedHour = document.querySelector(`[data-hour-id="${id}"]`);
                selectedHour.classList.remove("hours__hour--disabled");
                selectedHour.classList.add("hours__hour--selected");

                selectedHour.onclick = selectHour;
            })()

            
        };

        function searchTerm(e) {
            search[e.target.name] = e.target.value;

            // Restart the hidden fields and the hour selector

            inputHiddenHour.value = "";
            inputHiddenDay.value = "";

            // Disable previous hour if there is a new click

            const previousHour = document.querySelector(".hours__hour--selected");

            if(previousHour) {
                previousHour.classList.remove("hours__hour--selected");
            }

            // Basically if any of the values of the objects is empty then stops the execution of the function

            if(Object.values(search).includes("")) {
                return;
            };

            searchEvents();
        }

        async function searchEvents() {
            const {day, categorie_id} = search;
            const url = `/api/events-schedule?day_id=${day}&categorie_id=${categorie_id}`;

            // This waits until the connection with the url has been made before continuing executing code

            const result = await fetch(url);

            // This waits until an answer from said url, which is made in php, is given before continuing executing code

            const events = await result.json();

            obtainAvailableHours(events);
        }

        function obtainAvailableHours(events) {

            // Restart the hours

            const hoursList = document.querySelectorAll("#hours li");
            hoursList.forEach(li => li.classList.add("hours__hour--disabled"));

            // Check hours already taken and remove the disabled variable

            const hoursTaken = events.map(event => event.hour_id);

            // Changes hourList from a node list to an array

            const hoursListArray = Array.from(hoursList);

            // Fills result with all the li that are not the same as hoursTaken

            const result = hoursListArray.filter(li => !hoursTaken.includes(li.dataset.hourId));

            result.forEach(li => li.classList.remove("hours__hour--disabled"));

            const availableHours = document.querySelectorAll("#hours li:not(.hours__hour--disabled)");
            availableHours.forEach(hour => hour.addEventListener("click", selectHour));
        }

        function selectHour(e) {

            // Disable previous hour if there is a new click

            const previousHour = document.querySelector(".hours__hour--selected");

            if(previousHour) {
                previousHour.classList.remove("hours__hour--selected");
            }

            // Add class of selected

            e.target.classList.add("hours__hour--selected");

            inputHiddenHour.value = e.target.dataset.hourId;

            // Fill the hidden field of day

            inputHiddenDay.value = document.querySelector("[name='day']:checked").value;
        }
    }
})();
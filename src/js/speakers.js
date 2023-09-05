(function() {
    const speakersInput = document.querySelector("#speakers");

    if(speakersInput) {
        let speakers = [];
        let filteredSpeakers = [];

        const speakersList = document.querySelector("#speakers-list");
        const speakerHidden = document.querySelector('[name="speaker_id"]');

        obtainSpeakers();
        speakersInput.addEventListener("input", searchSpeakers);

        if(speakerHidden.value) {
            (async() => {
                const speaker = await obtainSpeaker(speakerHidden.value);

                // Insert in the html

                const speakerDOM = document.createElement("LI");
                speakerDOM.classList.add("speakers-list__speaker", "speakers-list__speaker--selected");
                speakerDOM.textContent = `${speaker.name} ${speaker.surname}`;

                speakersList.appendChild(speakerDOM);
            })();
        };

        async function obtainSpeakers() {
            const url = `/api/speakers`;

            // This waits until the connection with the url has been made before continuing executing code

            const answer = await fetch(url);

            // This waits until an answer from said url, which is made in php, is given before continuing executing code

            const result = await answer.json();
            formatSpeakers(result);
        };

        async function obtainSpeaker(id) {
            const url = `/api/speaker?id=${id}`;

            // This waits until the connection with the url has been made before continuing executing code

            const answer = await fetch(url);

            // This waits until an answer from said url, which is made in php, is given before continuing executing code

            const result = await answer.json();
            return result;
        };

        function formatSpeakers(arraySpeakers = []) {
            speakers = arraySpeakers.map(speaker => {
                return {
                    name: `${speaker.name.trim()} ${speaker.surname.trim()}`,
                    id: speaker.id
                };
            });
        };

        function searchSpeakers(e) {
            const search = e.target.value;

            if(search.length > 3) {

                // This is to create a new regular expression, that says that it doesn't matter if something it's in uppercase or lowercase, just the content, for that is the flag, the "i"

                const expression = new RegExp(search, "i");

                filteredSpeakers = speakers.filter(speaker => {
                    if(speaker.name.toLowerCase().search(expression) != -1) {
                        return speaker;
                    };
                });
            } else {
                filteredSpeakers = [];
            };

            showSpeakers();
        };

        function showSpeakers() {
            while(speakersList.firstChild) {
                speakersList.removeChild(speakersList.firstChild);
            };

            if(filteredSpeakers.length > 0) {
                filteredSpeakers.forEach(speaker => {
                    const speakerHTML = document.createElement("LI");
                    speakerHTML.classList.add("speakers-list__speaker");
                    speakerHTML.textContent = speaker.name;
                    speakerHTML.dataset.speakerId = speaker.id;
                    speakerHTML.onclick = selectSpeaker;
    
                    // Add to the DOM
    
                    speakersList.appendChild(speakerHTML);
                });
            } else {
                const noResults = document.createElement("P");
                noResults.classList.add("speakers-list__no-results");
                noResults.textContent = "There are no results to your search";
                speakersList.appendChild(noResults);
            };
        };

        function selectSpeaker(e) {
            const speaker = e.target;

            // Remove the previous class

            const previousSpeaker = document.querySelector(".speakers-list__speaker--selected");

            if(previousSpeaker) {
                previousSpeaker.classList.remove("speakers-list__speaker--selected");
            }

            speaker.classList.add("speakers-list__speaker--selected");

            speakerHidden.value = speaker.dataset.speakerId;
        }
    };
})();
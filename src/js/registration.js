import Swal from 'sweetalert2';

(function(){
    let events = [];

    const summary = document.querySelector('#register-summary');

    if(summary) {
        const eventsBtn = document.querySelectorAll('.event__add');
        eventsBtn.forEach(button => button.addEventListener('click', selectEvent));

        const registrationForm = document.querySelector('#register');
        registrationForm.addEventListener('submit', submitForm);

        showEvents();

        function selectEvent({target}) {

            if(events.length < 5) {

                // Disable the event

                target.disabled = true;
                events = [...events, {
                    id: target.dataset.id,
                    title: target.parentElement.querySelector('.event__name').textContent.trim()
                }];

                showEvents();

            } else {
                Swal.fire({
                    title: 'Error',
                    text: 'There is a maximum of 5 events per registration',
                    icon: 'error',
                    confirmButtonText: 'OK'
                })
            }
        }

        function showEvents() {

            // Clean the HTML

            cleanEvents();

            if(events.length > 0 ) {
                events.forEach( event => {
                    const eventDOM = document.createElement('DIV');
                    eventDOM.classList.add('register-pay__event');

                    const title = document.createElement('H3');
                    title.classList.add('register-pay__name');
                    title.textContent = event.title;

                    const deleteBtn = document.createElement('BUTTON');
                    deleteBtn.classList.add('register-pay__delete');
                    deleteBtn.innerHTML = `<i class="fa-solid fa-trash"></i>`;

                    deleteBtn.onclick = function() {
                        deleteEvent(event.id);
                    }

                    // Renderize the HTML

                    eventDOM.appendChild(title);
                    eventDOM.appendChild(deleteBtn);
                    summary.appendChild(eventDOM);
                })
            } else {
                const noRegister = document.createElement('P')
                noRegister.textContent = 'There are no events, add up to 5 from the left side';
                noRegister.classList.add('register-pay__text');
                summary.appendChild(noRegister);
            }
        }

        function deleteEvent(id) {
            events = events.filter(event => event.id !== id);
            const addBtn = document.querySelector(`[data-id="${id}"]`);
            addBtn.disabled = false;
            showEvents();
        }

        function cleanEvents() {
            while(summary.firstChild) {
                summary.removeChild(summary.firstChild);
            }
        }

        async function submitForm(e) {
            e.preventDefault();

            // Obtain the Gift

            const giftId = document.querySelector('#gift').value;
            const eventsId = events.map(event => event.id);

            if(eventsId.length === 0 || giftId === '') {
                 Swal.fire({
                    title: 'Error',
                    text: 'Choose at least an event and a gift',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
                return;
            }

            // Formdata object

            const data = new FormData();
            data.append('events', eventsId);
            data.append('gift_id', giftId);

            const url = '/finish-registration/conferences';
            const answer = await fetch(url, {
                method: 'POST',
                body: data
            });

            const result = await answer.json();

            if(result.result) {
                Swal.fire(
                    'Registration Successful',
                    'Your conferences are saved and your registration was successful, we will wait for you at the DevWebCamp',
                    'success'
                ).then( () => location.href = `/ticket?id=${result.token}`);
            } else {
                Swal.fire({
                    title: 'Error',
                    text: 'There has been an error',
                    icon: 'error',
                    confirmButtonText: 'OK'
                }).then( () => location.reload() )
            }
        }
    }
})();
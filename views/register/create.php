<main class="register">
    <h2 class="register__heading"><?php echo $title; ?></h2>
    <p class="register__description">Choose your plan</p>

    <div class="packages__grid">
        <div class="package">
            <h3 class="package__name">Free Pass</h3>
            <ul class="package__list">
                <li class="package__element">Virtual Access to DevWebCamp</li>
            </ul>

            <p class="package__price">$0</p>

            <form method="POST" action="/finish-registration/free">
                <input class="packages__submit" type="submit" value="Free Registration">
            </form>
        </div>

        <div class="package">
            <h3 class="package__name">Presential Pass</h3>
            <ul class="package__list">
                <li class="package__element">Presential Pass to DevWebCamp</li>
                <li class="package__element">2 days pass</li>
                <li class="package__element">Access to workshops and conferences</li>
                <li class="package__element">Access to the recordings</li>
                <li class="package__element">Event T-shirt</li>
                <li class="package__element">Food and Drink</li>
            </ul>

            <p class="package__price">$199</p>

            <div id="smart-button-container">
                <div style="text-align: center;">
                    <div id="paypal-button-container"></div>
                </div>
            </div>
        </div>

        <div class="package">
            <h3 class="package__name">Virtual Pass</h3>
            <ul class="package__list">
                <li class="package__element">Virtual Access to DevWebCamp</li>
                <li class="package__element">2 days pass</li>
                <li class="package__element">Access to workshops and conferences</li>
                <li class="package__element">Access to the recordings</li>
            </ul>

            <p class="package__price">$49</p>

            <div id="smart-button-container">
                <div style="text-align: center;">
                    <div id="paypal-button-container-virtual"></div>
                </div>
            </div>
        </div>
    </div>
</main>

<script src="https://www.paypal.com/sdk/js?client-id=Adc6YGqAvfmtD_7WCDB9mf3AidMfM18ZQr49mGkIHEOF8XuFTW7aAMFuB09wVfMsKy54lOoFfpWqL3HS&enable-funding=venmo&currency=USD" data-sdk-integration-source="button-factory"></script>

<script>
    function initPayPalButton() {
        paypal.Buttons({
            style: {
                shape: 'rect',
                color: 'blue',
                layout: 'vertical',
                label: 'pay',
            },

            createOrder: function(data, actions) {
                return actions.order.create({
                    purchase_units: [{
                        "description": "1",
                        "amount": {
                            "currency_code": "USD",
                            "value": 199
                        }
                    }]
                });
            },

            onApprove: function(data, actions) {
                return actions.order.capture().then(function(orderData) {

                    const data = new FormData();
                    data.append('package_id', orderData.purchase_units[0].description);
                    data.append('payment_id', orderData.purchase_units[0].payments.captures[0].id);

                    fetch('/finish-registration/pay', {
                            method: 'POST',
                            body: data
                        })
                        .then(answer => answer.json())
                        .then(result => {
                            if (result.result) {
                                actions.redirect('http://localhost:3000/finish-registration/conferences');
                            }
                        })

                });
            },

            onError: function(err) {
                console.log(err);
            }
        }).render('#paypal-button-container');


        // Virtual Pass

        paypal.Buttons({
            style: {
                shape: 'rect',
                color: 'blue',
                layout: 'vertical',
                label: 'pay',
            },

            createOrder: function(data, actions) {
                return actions.order.create({
                    purchase_units: [{
                        "description": "2",
                        "amount": {
                            "currency_code": "USD",
                            "value": 49
                        }
                    }]
                });
            },

            onApprove: function(data, actions) {
                return actions.order.capture().then(function(orderData) {

                    const data = new FormData();
                    data.append('package_id', orderData.purchase_units[0].description);
                    data.append('payment_id', orderData.purchase_units[0].payments.captures[0].id);

                    fetch('/finish-registration/pay', {
                            method: 'POST',
                            body: data
                        })
                        .then(answer => answer.json())
                        .then(result => {
                            if (result.result) {
                                actions.redirect('http://localhost:3000/finish-registration/conferences');
                            }
                        })

                });
            },

            onError: function(err) {
                console.log(err);
            }
        }).render('#paypal-button-container-virtual');

    }
    initPayPalButton();
</script>
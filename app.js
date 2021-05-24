const express = require ('express');
const ejs = require ('ejs');
const paypal = require ('paypal-rest-sdk');
const cors = require('cors')
const bodyParser = require("body-parser");

paypal.configure({
    'mode': 'sandbox', //sandbox or live
    'client_id': 'AZ1IItdvQng9nIs3tiyJ2xVIgzeaM0eFs_Or9u2nZrkC76rZ-xU5yRenGA5NYY4dn1T3qeU5pIxq5ETZ',
    'client_secret': 'EBc9cjaYYutQsDZvDYUzhex8eA0y5gYrgNV81MX3f8Mq0qr2trKQrgOMIib1ehdpV7bNirOis8yomrC6'
});


const app = express();
app.use(cors())
app.options('*', cors());  // enable pre-flight
app.use(bodyParser.json());
app.set('view engine', 'ejs');
app.get('/', function(req, res) {
    res.render('pages/');
});
//render index
//app.get('/', (req, res) => res.render('index'));
let create_payment_json = null;

app.post('/create_order', (req, res) => {
    create_payment_json = req.body;

    paypal.payment.create(create_payment_json, function (error, payment) {
        if (error) {
            throw error;
        } else {
            console.log(create_payment_json)
            for(let i = 0; i < payment.links.length; i++){
                if(payment.links[i].rel === 'approval_url'){
                    res.redirect(payment.links[i].href)
                }
            }
        }
    });
})


function pay(){
    /*const create_payment_json = {
        "intent": "sale",
        "payer": {
            "payment_method": "paypal"
        },
        "redirect_urls": {
            "return_url": "http://localhost:3000/success",
            "cancel_url": "http://localhost:3000/cancel"
        },
        "transactions": [{
            "item_list": {
                "items": [{
                    "name": "Red Sox",
                    "sku": "001",
                    "price": "25.00",
                    "currency": "USD",
                    "quantity": 1
                }]
            },
            "amount": {
                "currency": "USD",
                "total": "25.00"
            },
            "description": "This is the payment description."
        }]
    };*/
    /*paypal.payment.create(create_payment_json, function (error, payment) {
        if (error) {
            throw error;
        } else {
         for(let i = 0; i < payment.links.length; i++){
             if(payment.links[i].rel === 'approval_url'){
                 res.redirect(payment.links[i].href)
             }
         }
        }
    });*/
}

app.get('/success', (req, res) => {
    const payerId = req.query.PayerID;
    const paymentId = req.query.paymentId;

    const execute_payment_json = {
        "payer_id": payerId,
        "transactions": [{
            "amount": {
                "currency": "USD",
                "total": "25.00"
            }
        }]
    };

    paypal.payment.execute(paymentId, execute_payment_json, function (error, payment) {
        if (error) {
            console.log(error.response);
            throw error;
        } else {
            console.log(JSON.stringify(payment));
            res.send('Success');
        }
    });

})

app.post('/cancel', (req, res) => {
   res.send('Cancel123123');
});

app.listen(3000, () => console.log('Server Started'));


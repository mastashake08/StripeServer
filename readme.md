## Stripe Self-Payment Microservice

This Lumen microservice allows you to take one time payments using the Stripe PHP API.
Perfect for consultants or anyone who takes credit or debit cards. This app serves as the basis
for a programming blog on http://www.jyroneparker.com. It is also meant to be used in conjunction with the mobile app available at https://github.com/mastashake08/ParkerPay.

##Installation

To install this microservice clone this repository on your server and install the composer dependencies:
composer install

Next you need to rename .env.example to .env and fill in STRIPE_KEY and MAIL_* keys.

It would be in your best interest to run this code on an HTTPS server to further protect your client's information.

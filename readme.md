
# cjm's Submission For The Parking Lot App

## Assumptions:

This app assumes that there is a single parking lot and a single user present within the database. Seeders are provdied for both models, and can be run with:

* `php artisan migrate:refresh`

* `php artisan db:seed`

This will populate the database with both a user and a parking lot present for testing.

## Testing:

All tests are seperaete within the tests/ directory at the root of the application. The tests are seperaeted by being either Unit tests or Feature tests.

PHPUnit is installed into the application by using composer. The binary is located within the `./vendor/bin` directory. 

To run the tests run the `phpunit` executable against the Feature or Unit test directory respectively.
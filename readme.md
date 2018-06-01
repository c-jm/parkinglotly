
# Colin Mills's ParkingLotly

## Assumptions:

This app assumes that there is a single parking lot and a single user present within the database. Seeders are provdied for both models, and can be run with:

* `php artisan migrate:refresh`

* `php artisan db:seed`

This will populate the database with both a user and a parking lot present for Postman collection testing.


## Testing:

All tests are seperaete within the tests/ directory at the root of the application. The tests are seperaeted by being either Unit tests or Feature tests.

PHPUnit is installed into the application by using composer. The binary is located within the `./vendor/bin` directory. 

To run the tests run the `phpunit` executable against the Feature or Unit test directory respectively.


**NOTE**: that when running tests sqlite has been chosen to make the tests run faster.

### Unit Tests:

* TicketModelTests

* ParkingLotModelTests

### Feature Tests:

* ParkingLotControllerTests

* LeaveControllerTests

* PaymentControllerTests

All tests are located in the root of the Laravel application under the `tests/` directory.

## Postman Collection

There is also a *Postman* Colllection included with the application located under the `docs`.

To use the *Postman* collection within *Postman* go to:

`File -> Import`

And find the *.json file to import. 

**NOTE**:  The collection was saved as a `v1`postman collection.

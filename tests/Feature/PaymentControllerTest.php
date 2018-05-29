<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

use App\Models\ParkingLot;
use App\Models\Ticket;
use App\Models\User;

class PaymentControllerTest extends TestCase
{
    use RefreshDatabase;
    private $testCreditCardNumber;

    protected function setUp()
    {
        parent::setUp();
        $this->testCreditCardNumber = '378282246310005';
    }

    public function test_that_payments_can_be_created()
    {
        $lot = factory(ParkingLot::class)->create(['capacity' => 1]);
        $user = factory(User::class)->create();
        $ticket = $lot->newTicket($user->id);
        $this->assertTrue($lot->isFull);

        $uri = sprintf('/api/lots/%d/payments/%d', $lot->id, $ticket->id);
        $response = $this->json('POST', $uri, ['credit_card_number' => $this->testCreditCardNumber]);

        $ticket = $ticket->fresh();
        $lot = $lot->fresh();

        $this->assertFalse($lot->isFull);

        $payment = array_get(json_decode($response->getContent(), true), 'payment');
        
        $this->assertDatabaseHas('payments', $payment);
        $this->assertTrue($ticket->payment->id == $payment['id']);
    }

    public function test_that_payments_an_error_will_be_thrown_if_an_invalid_credit_card_is_provided()
    {
        $lot = factory(ParkingLot::class)->create(['capacity' => 1]);
        $user = factory(User::class)->create();
        $ticket = $lot->newTicket($user->id);

        $uri = sprintf('/api/lots/%d/payments/%d', $lot->id, $ticket->id);
        $response = $this->json('POST', $uri, ['credit_card_number' => 'aaabbbcc']);

        $response->assertJson(['message' => 'The given data was invalid.', 'errors' => ['credit_card_number' => ['validation.credit_card.card_invalid']]]);
    }

    
    public function test_that_if_a_ticket_has_a_payment_it_cant_be_paid_for_again()
    {
        $lot = factory(ParkingLot::class)->create();
        $user = factory(User::class)->create();
        $ticket = $lot->newTicket($user->id);
        $ticket->pay('testing_charge_id');

        $uri = sprintf('/api/lots/%d/payments/%d', $lot->id, $ticket->id);
        $response = $this->json('POST', $uri, ['credit_card_number' => $this->testCreditCardNumber]);

        $response->assertJson(['error' => sprintf("Ticket with id: %d in lot: %d has already been paid for", $ticket->id, $lot->id)]);
    }
}

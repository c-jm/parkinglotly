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

    public function test_that_payments_can_be_created()
    {
        $lot = factory(ParkingLot::class)->create(['capacity' => 1]);
        $user = factory(User::class)->create();
        $ticket = $lot->newTicket($user->id);
        $this->assertTrue($lot->isFull);

        $uri = sprintf('/api/lots/%d/payments/%d', $lot->id, $ticket->id);
        $response = $this->json('POST', $uri, ['credit_card_number' => '378282246310005']);

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
}

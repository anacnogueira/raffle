<?php

use Livewire\Livewire;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('should create a new raffle', function() {
    Livewire::test('raffle.create')
        ->set('name', 'Test Raffle')
        ->call('handle')
        ->assertDispatched('raffle::refresh')
        ->assertSet('name', '');

    $this->assertDatabaseHas('raffles', [
        'name' => 'Test Raffle'
    ]);
});

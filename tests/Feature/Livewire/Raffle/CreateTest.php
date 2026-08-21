<?php

use App\Models\Raffle;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;

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

describe('validations', function() {
    it('name should be required', function(){
        Livewire::test('raffle.create')
            ->set('name', '')
            ->call('handle')
            ->assertHasErrors(['name' => 'required']);
    });

    it('name should have at least 5 characters', function(){
        Livewire::test('raffle.create')
            ->set('name', 'abcd')
            ->call('handle')
            ->assertHasErrors(['name' => 'min:5']);
    });

    it('name should have a max of 255 characters', function(){
        Livewire::test('raffle.create')
            ->set('name', str_repeat('a', 256))
            ->call('handle')
            ->assertHasErrors(['name' => 'max:255']);
    });

     it('name should be unique', function(){
        Raffle::create(['name' => 'Unique Raffle']);

        Livewire::test('raffle.create')
            ->set('name', 'Unique Raffle')
            ->call('handle')
            ->assertHasErrors(['name' => 'unique']);
    });
});

<?php

use App\Models\User;
use Livewire\Livewire;

beforeEach(function () {
    $this->actingAs(
        User::where('id', 1)->first()
    );
});

it('See the brand list', function () {
    $response = $this->get('/brands');

    $response->assertStatus(200);
});

// logearse, ver, editar, eliminar, crear, usar filtros 
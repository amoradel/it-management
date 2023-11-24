<?php

use App\Filament\Resources\UserResource;
use App\Filament\Resources\UserResource\Pages\EditUser;
use App\Filament\Resources\UserResource\Pages\ListUsers;
use App\Models\User;
use Livewire\Livewire;

use function Pest\Livewire\livewire;

// ver, editar, eliminar, crear, usar filtros
// logearse
beforeEach(function () {
    $this->actingAs(
        User::where('id', 1)->first()
    );
});

// ver
// it('See the user list', function () {
//     $response = $this->get('/users');

//     $response->assertStatus(200);
// });
it('has posts page', function () {
    Livewire::test(ListUsers::class)->assertCanSeeTableRecords(
        User::limit(10)->get()
    );
});

// crear
// it('Can create brands', function () {
//     $userAttributes = [
//         'name' => 'John Doe',
//         'email' => 'johndoe@example.com',
//         'password' => 'secret_password',
//     ];

//     $response = $this->post('/users', $userAttributes);
//     $response->assertStatus(201); // 201 significa "Created"

//     // $response->assertJson(['message' => 'User created successfully']);
// });

// editar
// it('can update a user', function () {
//     // Crea un usuario para actualizar
//     $user = User::factory()->create();

//     // Define los nuevos valores para el usuario
//     $newAttributes = [
//         'name' => 'Updated Name',
//         'email' => 'updated_email@example.com',
//         'password' => 'new_password',
//     ];

//     // Envía una solicitud PUT para actualizar el usuario
//     $response = $this->put('/users/' . $user->id . '/edit', $newAttributes);

//     // Verifica que la solicitud de actualización haya tenido éxito
//     $response->assertStatus(200); // 200 significa "OK"
//     $response->assertJson(['message' => 'User updated successfully']);

// });

it('can go to the view edit users', function () {
    Livewire::test(ListUsers::class)->assertTableActionExists('edit');
});

// it('can go to the view edit users', function () {
//     Livewire::test(EditUser::class)->assertTableActionExists('edit');
// });

// eliminar
// it('Can delete brands', function () {
//     Livewire::test(UserResource::class)->assertTableActionExists('delete');
// });

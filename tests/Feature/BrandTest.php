<?php

use App\Filament\Resources\BrandResource;
use App\Filament\Resources\BrandResource\Pages\CreateBrand;
use App\Filament\Resources\BrandResource\Pages\EditBrand;
use App\Models\Brand;
use App\Models\User;
use Filament\Actions\CreateAction;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;

use function Pest\Laravel\actingAs;
use function Pest\Livewire\livewire;

uses(RefreshDatabase::class);

// logearse, ver, editar, eliminar, crear, usar filtros
// logearse
// beforeEach(function () {
//     $this->actingAs(
//         User::where('id', 1)->first()
//     );
// });

// ver
it('See the brand list', function () {

    $response = $this->get('/brands');

    $response->assertStatus(200);
});

it('create a brand', function () {
    $this->assertEquals(0, Brand::count());

    Livewire::test(CreateBrand::class)
        ->set('name', 'foo')
        ->call('create');

    $this->assertEquals(1, Brand::count());

    // dd(Brand::where('name','foo')->get());

    // $this->assertTrue();
});

// it('edit a brand', function (){
//     $brand = Brand::factory()->make(
//         [
//             'name'=> 'test'
//         ]
//         );

//     Livewire::test(EditBrand::class, ['brand' => $brand])
//     ->assertSet('name', 'test');
// });

// it('has posts page', function () {
//     Livewire::test(ListUsers::class)->assertCanSeeTableRecords(
//         User::limit(10)->get()
//     );
// });

// ver
// it('Can create brands', function () {
//     $brand = Brand::factory()->create();

//     livewire(BrandResource\Pages\CreateBrand::class)
//         ->callTableColumnAction(CreateAction::class, $brand);

//     $this->assertDatabaseCount((new Brand)->getTable(), 2);
// });

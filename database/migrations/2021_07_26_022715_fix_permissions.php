<?php

use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class FixPermissions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Eloquent::unguard();

        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        DB::table('permissions')->truncate();

        DB::table('role_has_permissions')->truncate();

        DB::table('model_has_permissions')->truncate();

        DB::table('model_has_roles')->truncate();

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        Permission::create(['name' => 'Create Combo']);
        Permission::create(['name' => 'Edit Combo']);
        Permission::create(['name' => 'Delete Combo']);
        Permission::create(['name' => 'Import Combo']);
        Permission::create(['name' => 'Export Combo']);

        Permission::create(['name' => 'Create Coupons']);
        Permission::create(['name' => 'Edit Coupons']);
        Permission::create(['name' => 'Delete Coupons']);
        Permission::create(['name' => 'Export Coupons']);
        Permission::create(['name' => 'Import Coupons']);

        Permission::create(['name' => 'Create Loyalty point']);
        Permission::create(['name' => 'Edit Loyalty point']);
        Permission::create(['name' => 'Delete Loyalty point']);
        Permission::create(['name' => 'Import Loyalty point']);
        Permission::create(['name' => 'Export Loyalty point']);

        Permission::create(['name' => 'Create Discounts']);
        Permission::create(['name' => 'Edit Discounts']);
        Permission::create(['name' => 'Delete Discounts']);
        Permission::create(['name' => 'Import Discounts']);
        Permission::create(['name' => 'Export Discounts']);

        Permission::create(['name' => 'Create Temporary activities']);
        Permission::create(['name' => 'Edit Temporary activities']);
        Permission::create(['name' => 'Delete Temporary activities']);
        Permission::create(['name' => 'Import Temporary activities']);
        Permission::create(['name' => 'Export Temporary activities']);

        Permission::create(['name' => 'Create Category']);
        Permission::create(['name' => 'Edit Category']);
        Permission::create(['name' => 'Delete Category']);
        Permission::create(['name' => 'Import Category']);
        Permission::create(['name' => 'Export Category']);

        Permission::create(['name' => 'Create Products']);
        Permission::create(['name' => 'Edit Products']);
        Permission::create(['name' => 'Delete Products']);
        Permission::create(['name' => 'Import Products']);
        Permission::create(['name' => 'Export Products']);

        Permission::create(['name' => 'Create Add ons']);
        Permission::create(['name' => 'Edit Add ons']);
        Permission::create(['name' => 'Delete Add ons']);
        Permission::create(['name' => 'Import Add ons']);
        Permission::create(['name' => 'Export Add ons']);

        Permission::create(['name' => 'Show menu']); //
        Permission::create(['name' => 'Activate menu']); //

        Permission::create(['name' => 'Create employee']);
        Permission::create(['name' => 'Edit employee']);
        Permission::create(['name' => 'Delete employee']);
        Permission::create(['name' => 'Import employee']);
        Permission::create(['name' => 'Export employee']);

        Permission::create(['name' => 'Restore Data']);

        Permission::create(['name' => 'Create Work Shift']);
        Permission::create(['name' => 'Edit Work Shift']);
        Permission::create(['name' => 'Delete Work Shift']);
        Permission::create(['name' => 'Import Work Shift']);
        Permission::create(['name' => 'Export Work Shift']);

        Permission::create(['name' => 'Create Delay policies']);
        Permission::create(['name' => 'Edit Delay policies']);
        Permission::create(['name' => 'Delete Delay policies']);
        Permission::create(['name' => 'Import Delay policies']);
        Permission::create(['name' => 'Export Delay policies']);

        Permission::create(['name' => 'Create Payment method']);
        Permission::create(['name' => 'Edit Payment method']);
        Permission::create(['name' => 'Delete Payment method']);
        Permission::create(['name' => 'Import Payment method']);
        Permission::create(['name' => 'Export Payment method']);

        Permission::create(['name' => 'Create Tags']);
        Permission::create(['name' => 'Edit Tags']);
        Permission::create(['name' => 'Delete Tags']);
        Permission::create(['name' => 'Import Tags']);
        Permission::create(['name' => 'Export Tags']);

        Permission::create(['name' => 'Work Information']);
        Permission::create(['name' => 'Application Settings']);

        Permission::create(['name' => 'Create Item inventory']);
        Permission::create(['name' => 'Edit Item inventory']);
        Permission::create(['name' => 'Delete Item inventory']);
        Permission::create(['name' => 'Import Item inventory']);
        Permission::create(['name' => 'Export Item inventory']);

        Permission::create(['name' => 'Create Suppliers']);
        Permission::create(['name' => 'Edit Suppliers']);
        Permission::create(['name' => 'Delete Suppliers']);
        Permission::create(['name' => 'Import Suppliers']);
        Permission::create(['name' => 'Export Suppliers']);

        Permission::create(['name' => 'Create Inventory process']);
        Permission::create(['name' => 'Edit Inventory process']);
        Permission::create(['name' => 'Delete Inventory process']);
        Permission::create(['name' => 'Import Inventory process']);
        Permission::create(['name' => 'Export Inventory process']);

        Permission::create(['name' => 'Show Reports']);
        Permission::create(['name' => 'Export Reports']);

        $webUserRole = Role::where('name', '=', 'web user')->first();

        $ownerRole = Role::where('name', '=', 'owner')->first();

        $permissions = Permission::get()->pluck('name');

        $webUserRole->givePermissionTo($permissions);

        $ownerRole->givePermissionTo($permissions);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}

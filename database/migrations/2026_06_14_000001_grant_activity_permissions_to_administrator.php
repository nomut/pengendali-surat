<?php

use Illuminate\Database\Migrations\Migration;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

return new class extends Migration
{
    /**
     * Permission untuk modul Kegiatan (activities). Dibuat lewat migration agar
     * database yang sudah ter-seed ikut mendapat permission ini tanpa perlu
     * seed ulang, sekaligus menetapkannya ke peran Administrator supaya tidak
     * kehilangan akses setelah route digated dengan can:activity-*.
     */
    private array $abilities = [
        'activity-index',
        'activity-create',
        'activity-update',
        'activity-delete',
    ];

    public function up(): void
    {
        app(PermissionRegistrar::class)->forgetCachedPermissions();

        foreach ($this->abilities as $ability) {
            Permission::findOrCreate($ability);
        }

        $administrator = Role::where('name', 'Administrator')->first();
        if ($administrator) {
            $administrator->givePermissionTo($this->abilities);
        }

        app(PermissionRegistrar::class)->forgetCachedPermissions();
    }

    public function down(): void
    {
        app(PermissionRegistrar::class)->forgetCachedPermissions();

        Permission::whereIn('name', $this->abilities)->delete();

        app(PermissionRegistrar::class)->forgetCachedPermissions();
    }
};

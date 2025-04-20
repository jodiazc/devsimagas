<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Definición de roles
        $roles = [
            'Administrador',
            'Operador',
            'Lecturistas',
            'Colaborador'
        ];

        // Creación de roles
        foreach ($roles as $roleName) {
            Role::firstOrCreate(['name' => $roleName, 'guard_name' => 'web']);
        }

        // Obtener instancias de roles
        $administrador = Role::where('name', 'Administrador')->first();
        $operador = Role::where('name', 'Operador')->first();
        $lecturista = Role::where('name', 'Lecturistas')->first();
        $colaborador = Role::where('name', 'Colaborador')->first();

        // Definición de permisos y roles asociados
        $permissions = [
            ['name' => 'admin.users.index', 'description' => 'Ver listado de usuarios', 'roles' => [$administrador]],
            ['name' => 'admin.users.edit', 'description' => 'Asignar un rol', 'roles' => [$administrador]],
            ['name' => 'admin.roles.index', 'description' => 'Ver listado de roles', 'roles' => [$administrador]],
            ['name' => 'admin.roles.create', 'description' => 'Crear rol', 'roles' => [$administrador]],
            ['name' => 'admin.roles.edit', 'description' => 'Editar un rol', 'roles' => [$administrador]],
            ['name' => 'admin.home', 'description' => 'Ver dashboard', 'roles' => [$administrador, $operador, $lecturista]],
            ['name' => 'admin.payments.index', 'description' => 'Ligas de pago', 'roles' => [$administrador, $operador, $lecturista]],
            ['name' => 'admin.payments.create', 'description' => 'Importación para ligas', 'roles' => [$administrador, $operador]],
            ['name' => 'admin.payments.export', 'description' => 'Exportar ligas', 'roles' => [$administrador, $operador]],
            ['name' => 'admin.upload_files.index', 'description' => 'Ligas de cargas', 'roles' => [$colaborador, $administrador]],
            ['name' => 'admin.upload_files.create', 'description' => 'Subir archivos', 'roles' => [$colaborador, $administrador]],
            ['name' => 'admin.upload_files.show', 'description' => 'Ver archivos', 'roles' => [$colaborador, $administrador]],
            ['name' => 'admin.registro.create', 'description' => 'Crear registro', 'roles' => [$administrador]],
            ['name' => 'admin.registro.index', 'description' => 'Listado registro', 'roles' => [$administrador]],
            ['name' => 'admin.almacenes.index', 'description' => 'Listado almacenes', 'roles' => [$administrador]],
        ];

        // Creación de permisos y asignación a roles
        foreach ($permissions as $perm) {
            $permission = Permission::firstOrCreate(
                ['name' => $perm['name'], 'guard_name' => 'web'],
                ['description' => $perm['description']]
            );
            $permission->syncRoles($perm['roles']);
        }
    }
}
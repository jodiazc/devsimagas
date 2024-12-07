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
            Role::firstOrCreate(['name' => $roleName]);
        }

        // Obtención de los roles
        $administrador = Role::where('name', 'Administrador')->first();
        $operador = Role::where('name', 'Operador')->first();
        $lecturista = Role::where('name', 'Lecturistas')->first();
        $colaborador = Role::where('name', 'Colaborador')->first();

        // Definición de permisos y su asignación
        $permissions = [
            ['name' => 'admin.users.index', 'description' => 'Ver LIstado de usuarios', 'roles' => [$administrador]],
            ['name' => 'admin.users.edit', 'description' => 'Asignar un rol', 'roles' => [$administrador]],
            ['name' => 'admin.roles.index', 'description' => 'Ver LIstado de Roles', 'roles' => [$administrador]],
            ['name' => 'admin.roles.create', 'description' => 'Crear Role', 'roles' => [$administrador]],
            ['name' => 'admin.roles.edit', 'description' => 'Editar un rol', 'roles' => [$administrador]],
            ['name' => 'admin.home', 'description' => 'Ver Dashboard', 'roles' => [$administrador, $operador, $lecturista]],
            ['name' => 'admin.payments.index', 'description' => 'Ligas de pago', 'roles' => [$administrador, $operador, $lecturista]],
            ['name' => 'admin.payments.create', 'description' => 'Importación para ligas', 'roles' => [$administrador, $operador]],
            ['name' => 'admin.payments.export', 'description' => 'Exportar Ligas', 'roles' => [$administrador, $operador]],
            ['name' => 'admin.upload_files.index', 'description' => 'Ligas de Cargas', 'roles' => [$colaborador, $administrador]],
            ['name' => 'admin.upload_files.create', 'description' => 'Subir Archivos', 'roles' => [$colaborador, $administrador]],
            ['name' => 'admin.upload_files.show', 'description' => 'Ver Archivos', 'roles' => [$colaborador, $administrador]],
        ];

        // Creación y asignación de permisos
        foreach ($permissions as $perm) {
            $permission = Permission::firstOrCreate(['name' => $perm['name'], 'description' => $perm['description']]);
            $permission->syncRoles($perm['roles']);
        }
    }
}

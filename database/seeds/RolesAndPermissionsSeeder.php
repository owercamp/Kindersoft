<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Restablecer roles y permisos de cache
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();


        Permission::create(['name' => 'ADMINISTRATIVO']);
        Permission::create(['name' => 'ADMINISTRATIVO JARDIN']);
        Permission::create(['name' => 'COMERCIAL']);
        Permission::create(['name' => 'LOGISTICO']);
        Permission::create(['name' => 'ACADEMICO']);

        Role::create(['name' => 'ADMINISTRADOR SISTEMA'])
            ->givePermissionTo(Permission::all());

        Role::create(['name' => 'ADMINISTRADOR'])
            ->givePermissionTo(['ADMINISTRATIVO']);

        Role::create(['name' => 'ADMINISTRADOR JARDIN'])
            ->givePermissionTo(['ADMINISTRATIVO JARDIN']);

        Role::create(['name' => 'COMERCIAL'])
            ->givePermissionTo(['COMERCIAL']);

        Role::create(['name' => 'LOGISTICO'])
            ->givePermissionTo(['LOGISTICO']);

        Role::create(['name' => 'ACADEMICO'])
            ->givePermissionTo(['ACADEMICO']);


        /*

        PERMISOS Y ROLES PARA PAQUETE SPATIE


        // Crear permisos para usuarios
        Permission::create(['name' => 'CrearUsuarios']);
        Permission::create(['name' => 'VerUsuarios']);
        Permission::create(['name' => 'EditarUsuarios']);
        Permission::create(['name' => 'EliminarUsuarios']);

        // Crear permisos para roles
        Permission::create(['name' => 'CrearRoles']);
        Permission::create(['name' => 'VerRoles']);
        Permission::create(['name' => 'EditarRoles']);
        Permission::create(['name' => 'EliminarRoles']);

        // Crear permisos para los permisos
        Permission::create(['name' => 'CrearPermisos']);
        Permission::create(['name' => 'VerPermisos']);
        Permission::create(['name' => 'EditarPermisos']);
        Permission::create(['name' => 'EliminarPermisos']);




        // Crear permisos para las ciudades


        Permission::create(['name' => 'CrearCiudades']);
        Permission::create(['name' => 'VerCiudades']);
        Permission::create(['name' => 'EditarCiudades']);
        Permission::create(['name' => 'EliminarCiudades']);

        // Crear permisos para las localidades
        Permission::create(['name' => 'CrearLocalidades']);
        Permission::create(['name' => 'VerLocalidades']);
        Permission::create(['name' => 'EditarLocalidades']);
        Permission::create(['name' => 'EliminarLocalidades']);

        // Crear permisos para las barrios
        Permission::create(['name' => 'CrearBarrios']);
        Permission::create(['name' => 'VerBarrios']);
        Permission::create(['name' => 'EditarBarrios']);
        Permission::create(['name' => 'EliminarBarrios']);

        // Crear permisos para los tipos de documentos
        Permission::create(['name' => 'CrearDocumentos']);
        Permission::create(['name' => 'VerDocumentos']);
        Permission::create(['name' => 'EditarDocumentos']);
        Permission::create(['name' => 'EliminarDocumentos']);

        // Crear permisos para los grupos sanguineos
        Permission::create(['name' => 'CrearRHs']);
        Permission::create(['name' => 'VerRHs']);
        Permission::create(['name' => 'EditarRHs']);
        Permission::create(['name' => 'EliminarRHs']);

        // Crear permisos para los titulos profesionales
        Permission::create(['name' => 'CrearProfesiones']);
        Permission::create(['name' => 'VerProfesiones']);
        Permission::create(['name' => 'EditarProfesiones']);
        Permission::create(['name' => 'EliminarProfesiones']);

        // Crear permisos para las entidades de salud
        Permission::create(['name' => 'CrearSalud']);
        Permission::create(['name' => 'VerSalud']);
        Permission::create(['name' => 'EditarSalud']);
        Permission::create(['name' => 'EliminarSalud']);

        // Crear permisos para los grados
        Permission::create(['name' => 'CrearGrados']);
        Permission::create(['name' => 'VerGrados']);
        Permission::create(['name' => 'EditarGrados']);
        Permission::create(['name' => 'EliminarGrados']);

        // Crear permisos para los cursos
        Permission::create(['name' => 'CrearCursos']);
        Permission::create(['name' => 'VerCursos']);
        Permission::create(['name' => 'EditarCursos']);
        Permission::create(['name' => 'EliminarCursos']);

        // Crear permisos para los inteligencias
        Permission::create(['name' => 'CrearInteligencias']);
        Permission::create(['name' => 'VerInteligencias']);
        Permission::create(['name' => 'EditarInteligencias']);
        Permission::create(['name' => 'EliminarInteligencias']);

        // Crear permisos para los logros
        Permission::create(['name' => 'CrearLogros']);
        Permission::create(['name' => 'VerLogros']);
        Permission::create(['name' => 'EditarLogros']);
        Permission::create(['name' => 'EliminarLogros']);


        // Crear roles y asignar permisos creados
        

        Role::create(['name' => 'Admin-system'])
            ->givePermissionTo(Permission::all());

        Role::create(['name' => 'Admin-org'])
            ->givePermissionTo([
                "VerUsuarios",
                "CrearCiudades", "VerCiudades", "EditarCiudades", "EliminarCiudades",
                "CrearLocalidades", "VerLocalidades", "EditarLocalidades", "EliminarLocalidades",
                "CrearBarrios", "VerBarrios", "EditarBarrios", "EliminarBarrios",
                "CrearDocumentos", "VerDocumentos", "EditarDocumentos", "EliminarDocumentos",
                "CrearRHs", "VerRHs", "EditarRHs", "EliminarRHs",
                "CrearProfesiones", "VerProfesiones", "EditarProfesiones", "EliminarProfesiones",
                "CrearSalud", "VerSalud", "EditarSalud", "EliminarSalud",
                "CrearGrados", "VerGrados", "EditarGrados", "EliminarGrados",
                "CrearCursos", "VerCursos", "EditarCursos", "EliminarCursos",
                "CrearInteligencias", "VerInteligencias", "EditarInteligencias", "EliminarInteligencias",
                "CrearLogros", "VerLogros", "EditarLogros", "EliminarLogros"
            ]);

        Role::create(['name' => 'see-org'])
            ->givePermissionTo([
                "VerCiudades",
                "VerLocalidades",
                "VerBarrios",
                "VerDocumentos",
                "VerRHs",
                "VerProfesiones",
                "VerSalud",
                "VerGrados",
                "VerCursos",
                "VerInteligencias",
                "VerLogros"
            ]);

        */
    }
}

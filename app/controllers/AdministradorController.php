<?php 

include_once "config/db_connection.php";
include_once "app/models/AdministradorModel.php";

class AdministradorController
{
    private $model;

    public function __construct($connection)
    {
        $this->model = new AdministradorModel($connection);
    }

    /* ============================================================
       FUNCIONES AUXILIARES
       ============================================================ */
    private function alertBack($msg)
    {
        echo "<script>alert('$msg'); window.history.back();</script>";
        exit;
    }

    private function alertRedirect($msg, $ruta)
    {
        echo "<script>alert('$msg'); window.location.href='$ruta';</script>";
        exit;
    }

    private function validarTelefono($telefono)
    {
        if (!preg_match('/^[0-9]{10}$/', $telefono)) {
            $this->alertBack("El número de teléfono debe contener exactamente 10 dígitos.");
        }
    }

    private function validarFechaNacimiento($fechaNac)
    {
        if (empty($fechaNac)) {
            $this->alertBack("La fecha de nacimiento no puede estar vacía.");
        }

        $fechaActual     = new DateTime();
        $fechaNacimiento = new DateTime($fechaNac);

        if ($fechaNacimiento > $fechaActual) {
            $this->alertBack("La fecha de nacimiento no puede ser mayor a hoy.");
        }

        $edad = $fechaNacimiento->diff($fechaActual)->y;

        if ($edad < 18) {
            $this->alertBack("El administrador debe tener al menos 18 años.");
        }

        if ($edad > 100) {
            $this->alertBack("La edad no puede ser mayor a 100 años.");
        }
    }

    /* ============================================================
       INSERTAR ADMINISTRADOR
       ============================================================ */
    public function insertarAdministrador()
    {
        if (isset($_POST['enviar'])) {

            $matricula = trim($_POST['matricula']);
            $nombre    = trim($_POST['nombre']);
            $paterno   = trim($_POST['paterno']);
            $materno   = trim($_POST['materno']);
            $telefono  = trim($_POST['telefono']);
            $fechaNac  = trim($_POST['fechaNac']);
            $pass      = trim($_POST['pass']);

            // VALIDACIONES
            $this->validarTelefono($telefono);
            $this->validarFechaNacimiento($fechaNac);

            // INSERTAR
            $insert = $this->model->insertarAdministrador(
                $matricula, $nombre, $paterno, $materno,
                $telefono, $fechaNac, $pass
            );

            if ($insert) {
                $this->alertRedirect("Registro exitoso", "index.php?controller=administrador&action=insertarAdministrador");
            } else {
                $this->alertRedirect("Error al registrar administrador", "index.php?controller=administrador&action=insertarAdministrador");
            }
        }

        include "app/views/form_insertAdministrador.php";
    }

    /* ============================================================
       CONSULTAR ADMINISTRADORES
       ============================================================ */
    public function consultarAdministrador()
    {
        $administradores = $this->model->consultarAdministrador();
        include "app/views/consult_administrador.php";
    }

    /* ============================================================
       ACTUALIZAR ADMINISTRADOR
       ============================================================ */
    public function actualizarAdministrador()
    {
        // Mostrar formulario
        if (isset($_GET['id'])) {

            $id = (int) $_GET['id'];
            $row = $this->model->consultarPorID($id);

            if (!$row) {
                $this->alertRedirect("Administrador no encontrado", "index.php?controller=administrador&action=consultarAdministrador");
            }

            include "app/views/editar_administrador.php";
            return;
        }

        // Guardar cambios
        if (isset($_POST['editar'])) {

            $ID_Administrador = (int) $_POST['id'];
            $matricula = trim($_POST['matricula']);
            $nombre    = trim($_POST['nombre']);
            $paterno   = trim($_POST['paterno']);
            $materno   = trim($_POST['materno']);
            $telefono  = trim($_POST['telefono']);
            $fechaNac  = trim($_POST['fechaNac']);
            $pass      = trim($_POST['pass']);

            // VALIDACIONES
            $this->validarTelefono($telefono);
            $this->validarFechaNacimiento($fechaNac);

            // ACTUALIZAR
            $update = $this->model->actualizarAdministrador(
                $ID_Administrador, $matricula, $nombre, $paterno,
                $materno, $telefono, $fechaNac, $pass
            );

            if ($update) {
                $this->alertRedirect("Actualización exitosa", "index.php?controller=administrador&action=consultarAdministrador");
            } else {
                $this->alertRedirect("Error al actualizar", "index.php?controller=administrador&action=consultarAdministrador");
            }
        }

        include "app/views/editar_administrador.php";
    }

    /* ============================================================
       ELIMINAR ADMINISTRADOR
       ============================================================ */
    public function eliminarAdministrador()
    {
        if (isset($_GET['id'])) {

            $id = (int) $_GET['id'];

            if ($id <= 0) {
                $this->alertBack("ID inválido.");
            }

            $delete = $this->model->eliminarAdministrador($id);

            if ($delete) {
                $this->alertRedirect("Eliminación exitosa", "index.php?controller=administrador&action=consultarAdministrador");
            } else {
                $this->alertRedirect("Error al eliminar", "index.php?controller=administrador&action=consultarAdministrador");
            }
        }
    }
}

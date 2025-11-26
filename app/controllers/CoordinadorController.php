<?php

include_once "config/db_connection.php";
include_once "app/models/CoordinadorModel.php";

/**
 * CONTROLADOR DE COORDINADORES
 * Maneja CRUD + validaciones
 */
class CoordinadorController
{
    private $model;

    public function __construct($connection)
    {
        $this->model = new CoordinadorModel($connection);
    }

    /* ============================================================
       VALIDACIONES REUTILIZABLES
       ============================================================ */

    // Validación teléfono
    private function validarTelefono($telefono)
    {
        if (!preg_match('/^[0-9]{10}$/', $telefono)) {
            $this->alertBack("El número de teléfono debe contener exactamente 10 dígitos y solo números.");
        }
    }

    // Validación fecha
    private function validarFechaNacimiento($fechaNac)
    {
        if (empty($fechaNac)) {
            $this->alertBack("La fecha de nacimiento no puede estar vacía.");
        }

        $fechaActual     = new DateTime();
        $fechaNacimiento = new DateTime($fechaNac);
        $edad            = $fechaNacimiento->diff($fechaActual)->y;

        if ($fechaNacimiento > $fechaActual) {
            $this->alertBack("La fecha de nacimiento no puede ser mayor a la fecha actual.");
        }

        if ($edad < 18) {
            $this->alertBack("El coordinador debe tener al menos 18 años.");
        }

        if ($edad > 100) {
            $this->alertBack("La edad no puede ser mayor a 100 años.");
        }
    }

    // Función para alertar y regresar
    private function alertBack($msg)
    {
        echo "<script>alert('$msg'); window.history.back();</script>";
        exit;
    }

    // Función para alertar + redirigir
    private function alertRedirect($msg, $ruta)
    {
        echo "<script>alert('$msg'); window.location.href='$ruta';</script>";
        exit;
    }

    /* ============================================================
       INSERTAR COORDINADOR
       ============================================================ */
    public function insertarCoordinador()
    {
        if (isset($_POST['enviar'])) {

            // Obtener datos
            $matricula  = $_POST['matricula'];
            $nombre     = $_POST['nombre'];
            $paterno    = $_POST['paterno'];
            $materno    = $_POST['materno'];
            $telefono   = $_POST['telefono'];
            $fechaNac   = $_POST['fechaNac'];
            $pass       = $_POST['pass'];

            // Validaciones
            $this->validarTelefono($telefono);
            $this->validarFechaNacimiento($fechaNac);

            // Insertar
            $insert = $this->model->insertarCoordinador($matricula, $nombre, $paterno, $materno, $telefono, $fechaNac, $pass);

            if ($insert) {
                $this->alertRedirect("Registro exitoso", "index.php?controller=coordinador&action=insertarCoordinador");
            } else {
                $this->alertRedirect("Error al registrar", "index.php?controller=coordinador&action=insertarCoordinador");
            }
        }

        include_once "app/views/form_insertCoordinador.php";
    }

    /* ============================================================
       CONSULTAR COORDINADORES
       ============================================================ */
    public function consultarCoordinador()
    {
        $coordinadores = $this->model->consultarCoordinador();
        include "app/views/consult_coordinador.php";
    }

    /* ============================================================
       ACTUALIZAR COORDINADOR
       ============================================================ */
    public function actualizarCoordinador()
    {
        // Mostrar formulario
        if (isset($_GET['id'])) {
            $id  = (int) $_GET['id'];
            $row = $this->model->consultarPorID($id);

            include_once "app/views/editar_coordinador.php";
            return;
        }

        // Procesar actualización
        if (isset($_POST['editar'])) {

            $ID_Coordinador = (int) $_POST['id'];
            $matricula      = $_POST['matricula'];
            $nombre         = $_POST['nombre'];
            $paterno        = $_POST['paterno'];
            $materno        = $_POST['materno'];
            $telefono       = $_POST['telefono'];
            $fechaNac       = $_POST['fechaNac'];
            $pass           = $_POST['pass'];

            // Validaciones
            $this->validarTelefono($telefono);
            $this->validarFechaNacimiento($fechaNac);

            // Actualizar
            $update = $this->model->actualizarCoordinador($ID_Coordinador, $matricula, $nombre, $paterno, $materno, $telefono, $fechaNac, $pass);

            if ($update) {
                $this->alertRedirect("Actualización exitosa", "index.php?controller=coordinador&action=consultarCoordinador");
            } else {
                $this->alertRedirect("Error al actualizar", "index.php?controller=coordinador&action=consultarCoordinador");
            }
        }

        include_once "app/views/editar_coordinador.php";
    }

    /* ============================================================
       ELIMINAR COORDINADOR
       ============================================================ */
    public function eliminarCoordinador()
    {
        if (isset($_GET['id'])) {

            $id = (int) $_GET['id'];

            $delete = $this->model->eliminarCoordinador($id);

            if ($delete) {
                $this->alertRedirect("Eliminación exitosa", "index.php?controller=coordinador&action=consultarCoordinador");
            } else {
                $this->alertRedirect("Error al eliminar", "index.php?controller=coordinador&action=consultarCoordinador");
            }
        }
    }
}

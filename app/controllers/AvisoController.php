<?php

include_once "config/db_connection.php";
include_once "app/models/AvisoModel.php";

/**
 * CONTROLADOR DE AVISOS
 * Gestión de CRUD + validaciones
 */
class AvisoController
{
    private $model;

    public function __construct($connection)
    {
        $this->model = new AvisoModel($connection);
    }

    /* ============================================================
       FUNCIONES AUXILIARES REUTILIZABLES
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

    /* ============================================================
       INSERTAR AVISO
       ============================================================ */
    public function insertarAviso()
    {
        if (isset($_POST['enviar'])) {

            $ID_Objeto   = (int) $_POST['ID_Objeto'];
            $ID_Area     = (int) $_POST['ID_Area'];
            $descripcion = trim($_POST['descripcion']);

            // ============================
            // VALIDACIONES
            // ============================
            if ($ID_Objeto <= 0) {
                $this->alertBack("Debe seleccionar un objeto.");
            }

            if ($ID_Area <= 0) {
                $this->alertBack("Debe seleccionar un área.");
            }

            if ($descripcion === "") {
                $this->alertBack("La descripción no puede estar vacía.");
            }

            // Guardar en BD
            $insert = $this->model->insertarAviso($ID_Objeto, $ID_Area, $descripcion);

            if ($insert) {
                echo "<script>
                    alert('Registro exitoso');
                  </script>";
            } else {
                echo "<script>
                    alert('Error al registrar');
                  </script>";
            }
        }

        // Datos para dropdowns
        $objetos = $this->model->consultarObjetos();
        $areas   = $this->model->consultarAreas();

        include "app/views/form_insertAviso.php";
    }

    /* ============================================================
       CONSULTAR AVISOS - ADMIN / COORDINADOR
       ============================================================ */
    public function consultarAviso()
    {
        $avisos = $this->model->consultarAviso();
        include "app/views/consult_aviso.php";
    }

    /* ============================================================
       CONSULTAR AVISOS - ALUMNO
       ============================================================ */
    public function consultarAvisoAlumno()
    {
        $avisos = $this->model->consultarAviso();
        include "app/views/consult_avisoAlumno.php";
    }

    /* ============================================================
       ACTUALIZAR AVISO
       ============================================================ */
    public function actualizarAviso()
    {
        // ── 1) Cargar formulario con datos ──────────────────────
        if (isset($_GET['id'])) {

            $id_aviso = (int) $_GET['id'];
            $dato     = $this->model->consultarPorID($id_aviso);

            if (!$dato) {
                $this->alertRedirect("El aviso no existe.", "index.php?action=consultarAviso");
            }

            $objetos = $this->model->consultarObjetos();
            $areas   = $this->model->consultarAreas();

            include "app/views/editar_aviso.php";
            return;
        }

        // ── 2) Guardar cambios ──────────────────────────────────
        if (isset($_POST['editar'])) {

            $btn_rol     = (int) $_POST['rol'];
            $ID_Aviso    = (int) $_POST['ID_Aviso'];
            $ID_Objeto   = (int) $_POST['ID_Objeto'];
            $ID_Area     = (int) $_POST['ID_Area'];
            $descripcion = trim($_POST['descripcion']);

            // VALIDACIONES
            if ($ID_Aviso <= 0)      $this->alertBack("ID de aviso inválido.");
            if ($ID_Objeto <= 0)     $this->alertBack("Debe seleccionar un objeto.");
            if ($ID_Area <= 0)       $this->alertBack("Debe seleccionar un área.");
            if ($descripcion === "") $this->alertBack("La descripción no puede estar vacía.");

            // Actualizar
            $update = $this->model->actualizarAviso($ID_Aviso, $ID_Objeto, $ID_Area, $descripcion);

            $ruta = "index.php?controller=aviso&action=consultarAviso&rol={$btn_rol}";

            if ($update) {
                $this->alertRedirect("Actualización exitosa", $ruta);
            } else {
                $this->alertRedirect("Error al actualizar", $ruta);
            }
        }
    }

    /* ============================================================
       ELIMINAR AVISO
       ============================================================ */
    public function eliminarAviso()
    {
        if (isset($_GET['id'])) {

            $btn_rol = (int) $_GET['rol'];
            $id      = (int) $_GET['id'];

            if ($id <= 0) {
                $this->alertBack("ID inválido.");
            }

            $delete = $this->model->eliminarAviso($id);

            $ruta = "index.php?controller=aviso&action=consultarAviso&rol={$btn_rol}";

            if ($delete) {
                $this->alertRedirect("Eliminación exitosa", $ruta);
            } else {
                $this->alertRedirect("Error al eliminar", $ruta);
            }
        }
    }
}

<?php 

include_once "config/db_connection.php";
include_once "app/models/AlumnoModel.php";

/**
 * CONTROLADOR DE ALUMNOS
 * CRUD + validaciones + código optimizado
 */
class AlumnoController
{
    private $model;

    public function __construct($connection)
    {
        $this->model = new AlumnoModel($connection);
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
            $this->alertBack("La fecha de nacimiento es obligatoria.");
        }

        $fechaActual     = new DateTime();
        $fechaNacimiento = new DateTime($fechaNac);

        if ($fechaNacimiento > $fechaActual) {
            $this->alertBack("La fecha de nacimiento no puede ser mayor a hoy.");
        }

        $edad = $fechaNacimiento->diff($fechaActual)->y;

        if ($edad < 18) {
            $this->alertBack("El alumno debe ser mayor de edad.");
        }

        if ($edad > 100) {
            $this->alertBack("La edad no puede ser mayor a 100 años.");
        }
    }

    /* ============================================================
       INSERTAR ALUMNO
       ============================================================ */
    public function insertarAlumno()
    {
        $programas = $this->model->consultarPrograma();

        if (isset($_POST['enviar'])) {
            $matricula  = trim($_POST['matricula']);
            $nombre     = trim($_POST['nombre']);
            $paterno    = trim($_POST['paterno']);
            $materno    = trim($_POST['materno']);
            $telefono   = trim($_POST['telefono']);
            $fechaNac   = trim($_POST['fechaNac']);
            $pass       = trim($_POST['pass']);
            $ID_Programa = (int) $_POST['ID_Programa'];

            // VALIDACIONES
            $this->validarTelefono($telefono);
            $this->validarFechaNacimiento($fechaNac);

            // INSERTAR
            $insert = $this->model->insertarAlumno(
                $matricula, $nombre, $paterno, $materno,
                $telefono, $fechaNac, $pass, $ID_Programa
            );

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

        include "app/views/form_insertAlumno.php";
    }

    /* ============================================================
       CONSULTAR ALUMNOS
       ============================================================ */
    public function consultarAlumno()
    {
        $alumnos = $this->model->consultarAlumno();
        include "app/views/consult_alumno.php";
    }

    /* ============================================================
       ACTUALIZAR ALUMNO
       ============================================================ */
    public function actualizarAlumno()
    {
        $programas = $this->model->consultarPrograma();

        // 1) Cargar formulario
        if (isset($_GET['id'])) {

            $id = (int) $_GET['id'];
            $row = $this->model->consultarPorID($id);

            if (!$row) {
                $this->alertRedirect("El alumno no existe.", "index.php?controller=alumno&action=consultarAlumno");
            }

            include "app/views/editar_alumno.php";
            return;
        }

        // 2) Guardar cambios
        if (isset($_POST['editar'])) {

            $btn_rol     = (int) $_POST['rol'];
            $ID_Alumno   = (int) $_POST['id'];
            $matricula   = trim($_POST['matricula']);
            $nombre      = trim($_POST['nombre']);
            $paterno     = trim($_POST['paterno']);
            $materno     = trim($_POST['materno']);
            $telefono    = trim($_POST['telefono']);
            $fechaNac    = trim($_POST['fechaNac']);
            $pass        = trim($_POST['pass']);
            $ID_Programa = (int) $_POST['ID_Programa'];

            // VALIDACIONES
            $this->validarTelefono($telefono);
            $this->validarFechaNacimiento($fechaNac);

            // ACTUALIZAR
            $update = $this->model->actualizarAlumno(
                $ID_Alumno, $matricula, $nombre, $paterno, $materno,
                $telefono, $fechaNac, $pass, $ID_Programa
            );

            if ($update) {
                $this->alertRedirect(
                    "Actualización exitosa",
                    "index.php?controller=alumno&action=consultarAlumno&rol={$btn_rol}"
                );
            } else {
                $this->alertRedirect(
                    "Error al actualizar",
                    "index.php?controller=alumno&action=consultarAlumno&rol={$btn_rol}"
                );
            }
        }

        include "app/views/editar_alumno.php";
    }

    /* ============================================================
       ELIMINAR ALUMNO
       ============================================================ */
    public function eliminarAlumno()
    {
        if (isset($_GET['id'])) {

            $btn_rol = (int) $_GET['rol'];
            $id      = (int) $_GET['id'];

            if ($id <= 0) {
                $this->alertBack("ID inválido.");
            }

            $delete = $this->model->eliminarAlumno($id);

            if ($delete) {
                $this->alertRedirect(
                    "Eliminación exitosa",
                    "index.php?controller=alumno&action=consultarAlumno&rol={$btn_rol}"
                );
            } else {
                $this->alertRedirect(
                    "Error al eliminar",
                    "index.php?controller=alumno&action=consultarAlumno&rol={$btn_rol}"
                );
            }
        }
    }

}

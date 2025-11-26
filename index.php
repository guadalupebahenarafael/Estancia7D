<?php 
//AAAAAAAAAAAAAAAAA
/*------------------------------------------------------------
 | Importación de Controladores y Dependencias principales
 *-----------------------------------------------------------*/
include_once "config/db_connection.php";
include_once "app/middleware/auth.php";

include_once "app/controllers/AuthController.php";
include_once "app/controllers/AreaController.php";
include_once "app/controllers/ProgramaController.php";
include_once "app/controllers/AlumnoController.php";
include_once "app/controllers/CoordinadorController.php";
include_once "app/controllers/AdministradorController.php";
include_once "app/controllers/ObjetoController.php";
include_once "app/controllers/RespaldoController.php";
include_once "app/controllers/RestauracionController.php";
include_once "app/controllers/ReportController.php";
include_once "app/controllers/AvisoController.php";


/*------------------------------------------------------------
 | Instancia de controladores (inyección de conexión)
 *-----------------------------------------------------------*/
$auth                   = new AuthController($connection);
$AreaController         = new AreaController($connection);
$ProgramaController     = new ProgramaController($connection);
$AlumnoController       = new AlumnoController($connection);
$CoordinadorController  = new CoordinadorController($connection);
$AdministradorController= new AdministradorController($connection);
$ObjetoController       = new ObjetoController($connection);
$ReportController       = new ReportController($connection);
$RespaldoController     = new RespaldoController($connection);
$RestauracionController = new RestauracionController($connection);
$AvisoController        = new AvisoController($connection);


/*------------------------------------------------------------
 | Determinar acción solicitada (router principal)
 *-----------------------------------------------------------*/
$action = $_GET['action'] ?? 'login';


/*------------------------------------------------------------
 | Enrutador principal mediante switch-case
 *-----------------------------------------------------------*/
switch ($action) {

    /*---------------------------
     | Acciones de autenticación
     *--------------------------*/
    case 'login':
        $auth->showLogin();
        break;

    case 'doLogin':
        $auth->doLogin();
        break;

    case 'logout':
        $auth->logout();
        break;


    /*------------------------------------------
     | Dashboards según rol del usuario logeado
     *-----------------------------------------*/
    case 'dashboard_admin':
        require_role('administrador');
        include "app/views/dashboards/admin.php";
        break;

    case 'dashboard_coord':
        require_role('coordinador');
        include "app/views/dashboards/coord.php";
        break;

    case 'dashboard_alumno':
        require_login();
        include "app/views/dashboards/alumno.php";
        break;


    /*------------------
     | CRUD: Áreas
     *-----------------*/
    case 'insertarArea':
        $AreaController->insertarArea();
        break;

    case 'consultarArea':
        $AreaController->consultarArea();
        break;

    case 'actualizarArea':
        $AreaController->actualizarArea();
        break;

    case 'eliminarArea':
        $AreaController->eliminarArea();
        break;


    /*----------------------
     | CRUD: Programas
     *---------------------*/
    case 'insertarPrograma':
        $ProgramaController->insertarPrograma();
        break;

    case 'consultarPrograma':
        $ProgramaController->consultarPrograma();
        break;

    case 'actualizarPrograma':
        $ProgramaController->actualizarPrograma();
        break;

    case 'eliminarPrograma':
        $ProgramaController->eliminarPrograma();
        break;


    /*---------------------
     | CRUD: Avisos
     *--------------------*/
    case 'insertarAviso':
        $AvisoController->insertarAviso();
        break;

    case 'consultarAviso':
        $AvisoController->consultarAviso();
        break;

    case 'actualizarAviso':
        $AvisoController->actualizarAviso();
        break;

    case 'eliminarAviso':
        $AvisoController->eliminarAviso();
        break;


    /*----------------------
     | CRUD: Alumnos
     *---------------------*/
    case 'insertarAlumno':
        $AlumnoController->insertarAlumno();
        break;

    case 'consultarAlumno':
        $AlumnoController->consultarAlumno();
        break;

    case 'actualizarAlumno':
        $AlumnoController->actualizarAlumno();
        break;

    case 'eliminarAlumno':
        $AlumnoController->eliminarAlumno();
        break;


    /*-------------------------
     | CRUD: Coordinadores
     *------------------------*/
    case 'insertarCoordinador':
        $CoordinadorController->insertarCoordinador();
        break;

    case 'consultarCoordinador':
        $CoordinadorController->consultarCoordinador();
        break;

    case 'actualizarCoordinador':
        $CoordinadorController->actualizarCoordinador();
        break;

    case 'eliminarCoordinador':
        $CoordinadorController->eliminarCoordinador();
        break;


    /*--------------------------
     | CRUD: Administradores
     *-------------------------*/
    case 'insertarAdministrador':
        $AdministradorController->insertarAdministrador();
        break;

    case 'consultarAdministrador':
        $AdministradorController->consultarAdministrador();
        break;

    case 'actualizarAdministrador':
        $AdministradorController->actualizarAdministrador();
        break;

    case 'eliminarAdministrador':
        $AdministradorController->eliminarAdministrador();
        break;


    /*------------------
     | CRUD: Objetos
     *-----------------*/
    case 'insertarObjeto':
        $ObjetoController->insertarObjeto();
        break;

    case 'consultarObjeto':
        $ObjetoController->consultarObjeto();
        break;

    case 'actualizarObjeto':
        $ObjetoController->actualizarObjeto();
        break;

    case 'eliminarObjeto':
        $ObjetoController->eliminarObjeto();
        break;


    /*------------------------------
     | Reportes PDF / Gráficas
     *-----------------------------*/
    case 'vistaReportePorCategoria':
        $ReportController->vistaReportePorCategoria();
        break;

    case 'reporteObjetosPorCategoria':
        $ReportController->ReporteObjetosPorCategoria();
        break;

    case 'vistaReportePorEdificio':
        $ReportController->vistaReportePorEdificio();
        break;

    case 'reporteObjetosPorEdificio':
        $ReportController->ReporteObjetosPorEdificio();
        break;

    case 'vistaReportePorGenero':
        $ReportController->vistaReportePorGenero();
        break;

    case 'reporteObjetosPorGenero':
        $ReportController->ReporteObjetosPorGenero();
        break;

    case 'pdf_pie':
        $ReportController->generarPastel();
        break;

    case 'pdf_pieCategoria':
        $ReportController->generarPastelCategoria();
        break;

    case 'pdf_pieEdificio':
        $ReportController->generarPastelEdificio();
        break;

    /*------------------------------
     | Respaldos y Restauraciones
     *-----------------------------*/
    case 'crearRespaldo':
        $RespaldoController->realizarRespaldoBD();
        break;

    case 'vistaRestauracion':
        $RestauracionController->vistaRestauracion();
        break;

    case 'restaurarVersion':
        $RestauracionController->restaurarVersion();
        break;

    /*------------------------------
     | Avisos para alumnos
     *-----------------------------*/
    case 'avisos':
        $AvisoController->consultarAvisoAlumno();
        break;


    /*--------------------------------
     | Opción por defecto
     *-------------------------------*/
    default:
        $auth->showLogin();
        break;
}

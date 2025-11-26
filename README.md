Este repositorio contiene el código fuente del proyecto desarrollado para la estancia profesional. Incluye el sistema web en arquitectura MVC y el archivo SQL necesario para configurar la base de datos.

Estructura del proyecto / |-- app/ |-- public/ |-- config/ └── backups/ | └── db-backup-2025-11-21.sql ← Archivo SQL de la base de datos |-- index.php

Base de Datos El archivo SQL se encuentra en: backups/db-backup-2025-11-21.sql

Cómo importar la base de datos (MariaDB)

Crear la base de datos en localhost: CREATE DATABASE objetos_perdidos;

Importar el archivo SQL: mysql -u root -p nombre_de_tu_base < backups/db-backup-2025-11-21.sql

Dependencias necesarias:

1.- PHP X.X 2.- MySQL / MariaDB 3.- Apache o XAMPP 4.- Extensión mysqli habilitada 5.- Extenciones para crear los pdf como fpdf y phplot

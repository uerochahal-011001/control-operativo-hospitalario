# Control Operativo Hospitalario Demo

Sistema interno hospitalario para registrar, consultar y analizar incidencias operativas.

## 📋 Requisitos

- XAMPP (Apache, PHP, MySQL)
- PHP 7.4 o superior
- MySQL 5.7 o superior
- Navegador web moderno

## 📁 Estructura del Proyecto

```
control-operativo-hospitalario/
├── README.md
├── INSTRUCCIONES_INSTALACION.md
├── database/
│   └── control_operativo_demo.sql
├── public/
│   ├── index.php
│   ├── login.php
│   ├── logout.php
│   ├── dashboard.php
│   ├── incidencias.php
│   ├── nuevo-incidente.php
│   ├── editar-incidente.php
│   ├── bitacora.php
│   ├── css/
│   │   └── styles.css
│   └── js/
│       ├── charts.js
│       ├── validations.js
│       └── main.js
├── app/
│   ├── config.php
│   ├── db.php
│   ├── auth.php
│   ├── functions.php
│   └── bitacora.php
└── assets/
    └── placeholder.txt
```

## 🚀 Instalación Rápida

### Paso 1: Descargar el proyecto
```bash
git clone https://github.com/uerochahal-011001/control-operativo-hospitalario.git
```

### Paso 2: Copiar a htdocs
Copiar la carpeta al directorio:
```
C:\xampp\htdocs\control-operativo-hospitalario
```

### Paso 3: Crear base de datos

1. Abrir **phpMyAdmin**: http://localhost/phpmyadmin
2. Hacer clic en **Nueva base de datos**
3. Escribir nombre: `control_operativo_demo`
4. Hacer clic en **Crear**
5. Seleccionar la nueva base de datos
6. Ir a la pestaña **Importar**
7. Buscar archivo: `database/control_operativo_demo.sql`
8. Hacer clic en **Ejecutar**

### Paso 4: Acceder a la aplicación

- **URL**: http://localhost/control-operativo-hospitalario/public/
- **Usuario**: admin@hospital.com
- **Contraseña**: Admin123

## 👥 Usuarios de Prueba

| Email | Contraseña | Rol |
|-------|-----------|-----|
| admin@hospital.com | Admin123 | Administrador |
| supervisor@hospital.com | Supervisor123 | Supervisor |
| captura@hospital.com | Captura123 | Capturista |

## 🔐 Características de Seguridad

✅ Consultas preparadas (prevención de inyección SQL)  
✅ Sesiones protegidas  
✅ Contraseñas hasheadas con bcrypt  
✅ Validación de formularios  
✅ Sanitización de salida HTML  
✅ Bloqueo de acceso sin sesión  

## 📊 Funcionalidades

✅ **Autenticación**: Login con roles (Administrador, Supervisor, Capturista)  
✅ **Dashboard**: Estadísticas en tiempo real con gráficas  
✅ **Incidencias**: Crear, editar, eliminar, filtrar y buscar  
✅ **Filtros avanzados**: Por área, prioridad y estatus  
✅ **Bitácora**: Registro automático de todas las acciones  
✅ **Gráficas**: Incidencias por área, prioridad y estatus  
✅ **Responsive**: Diseño adaptable a todos los dispositivos  
✅ **Diseño profesional**: Colores hospitalarios (azul, dorado, blanco, gris)  

## 📖 Guía de Uso

### Como Administrador
- Acceso completo a todas las funciones
- Ver y gestionar todas las incidencias
- Ver bitácora de movimientos
- Asignar responsables

### Como Supervisor
- Ver todas las incidencias
- Editar estado de incidencias
- Ver bitácora de movimientos
- Crear nuevas incidencias

### Como Capturista
- Crear nuevas incidencias
- Ver incidencias propias
- Editar incidencias propias

## 🛠️ Solución de Problemas

**Error: "Base de datos no encontrada"**
- Verificar que la base de datos fue importada correctamente en phpMyAdmin
- Verificar el nombre en `app/config.php`

**Error: "No se puede conectar a MySQL"**
- Verificar que Apache y MySQL estén iniciados en XAMPP
- Verificar usuario y contraseña en `app/config.php`

**Error: "Sesión expirada"**
- Esto es normal. Inicie sesión nuevamente.

## 📄 Licencia

Proyecto de demostración educativa.

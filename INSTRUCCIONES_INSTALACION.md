# 📋 Instrucciones de Instalación - Control Operativo Hospitalario Demo

## Requisitos Previos

- **XAMPP** instalado en tu computadora
  - Descarga desde: https://www.apachefriends.org/es/index.html
  - Versión recomendada: XAMPP con PHP 7.4+
- **Git** instalado (opcional, para clonar el repositorio)
- **Navegador web moderno** (Chrome, Firefox, Edge)

---

## ⚙️ Paso 1: Verificar XAMPP

1. **Abrir el Panel de Control de XAMPP**
   - Windows: `C:\xampp\xampp-control.exe`
   - Mac/Linux: Terminal y ejecutar `./xampp/manager-linux.run`

2. **Iniciar servicios**
   - Hacer clic en **Start** para **Apache**
   - Hacer clic en **Start** para **MySQL**
   - Ambos deben mostrar estado **Running** en color verde

3. **Verificar Apache**
   - Abrir navegador: http://localhost
   - Debe aparecer la página de bienvenida de XAMPP

---

## 📁 Paso 2: Descargar y Copiar el Proyecto

### Opción A: Usando Git

```bash
# Abrir Terminal o Command Prompt en la carpeta htdocs
cd C:\xampp\htdocs

# Clonar el repositorio
git clone https://github.com/uerochahal-011001/control-operativo-hospitalario.git

# Entrar a la carpeta
cd control-operativo-hospitalario
```

### Opción B: Descarga Manual

1. Ir a: https://github.com/uerochahal-011001/control-operativo-hospitalario
2. Hacer clic en **Code** → **Download ZIP**
3. Descomprimir en: `C:\xampp\htdocs\`
4. La carpeta debe llamarse: `control-operativo-hospitalario`

**Verificar la ruta:**
```
C:\xampp\htdocs\control-operativo-hospitalario
├── public/
├── app/
├── database/
└── README.md
```

---

## 🗄️ Paso 3: Crear la Base de Datos

### Método 1: phpMyAdmin (Recomendado)

1. **Abrir phpMyAdmin**
   - URL: http://localhost/phpmyadmin
   - Usuario: `root`
   - Contraseña: (vacío)

2. **Crear nueva base de datos**
   - En el menú izquierdo, hacer clic en **Nueva base de datos**
   - Escribir nombre: `control_operativo_demo`
   - Conjunto de caracteres: `utf8mb4_unicode_ci`
   - Hacer clic en **Crear**

3. **Importar datos**
   - Seleccionar la base de datos `control_operativo_demo`
   - Ir a la pestaña **Importar**
   - Hacer clic en **Seleccionar archivo**
   - Buscar: `database/control_operativo_demo.sql`
   - Hacer clic en **Ejecutar**

4. **Verificar**
   - Hacer clic en la base de datos
   - Debe mostrar 3 tablas:
     - `usuarios`
     - `incidencias`
     - `bitacora_movimientos`

### Método 2: MySQL Command Line

```bash
# Abrir Command Prompt como Administrador
# Navegar a: C:\xampp\mysql\bin
cd C:\xampp\mysql\bin

# Conectar a MySQL
mysql -u root -p

# Si pide contraseña, presionar Enter (sin contraseña)

# Crear base de datos
CREATE DATABASE control_operativo_demo CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

# Usar la base de datos
USE control_operativo_demo;

# Importar archivo SQL
source "C:/xampp/htdocs/control-operativo-hospitalario/database/control_operativo_demo.sql";

# Verificar tablas
SHOW TABLES;

# Salir
EXIT;
```

---

## 🔧 Paso 4: Configurar la Aplicación

1. **Abrir el archivo de configuración**
   - Ruta: `app/config.php`
   - Verificar datos de conexión:
     ```php
     define('DB_HOST', 'localhost');
     define('DB_USER', 'root');
     define('DB_PASS', '');
     define('DB_NAME', 'control_operativo_demo');
     ```
   - Si tu MySQL tiene contraseña, modificar `DB_PASS`

2. **Verificar permisos de carpetas** (Windows generalmente no es necesario)
   - Carpetas deben ser legibles y escribibles

---

## 🚀 Paso 5: Acceder a la Aplicación

1. **Abrir navegador**

2. **Ir a la URL**
   ```
   http://localhost/control-operativo-hospitalario/public/
   ```

3. **Esperar que cargue**
   - Debe mostrar la página de login

---

## 👤 Paso 6: Iniciar Sesión

### Usuarios disponibles:

#### Administrador
- **Email**: admin@hospital.com
- **Contraseña**: Admin123
- **Acceso**: Todas las funciones

#### Supervisor
- **Email**: supervisor@hospital.com
- **Contraseña**: Supervisor123
- **Acceso**: Gestionar incidencias y ver bitácora

#### Capturista
- **Email**: captura@hospital.com
- **Contraseña**: Captura123
- **Acceso**: Crear y editar propias incidencias

---

## ✅ Pruebas Iniciales

### Como Administrador:
1. ✅ Ir al **Dashboard** - Ver gráficas
2. ✅ Ir a **Incidencias** - Ver tabla
3. ✅ Crear **nueva incidencia**
4. ✅ Editar una incidencia
5. ✅ Ver **Bitácora** de movimientos
6. ✅ Cerrar sesión

### Como Supervisor:
1. ✅ Verificar acceso a Dashboard
2. ✅ Crear incidencia
3. ✅ Ver bitácora
4. ✅ Intentar eliminar (no debe permitir)

### Como Capturista:
1. ✅ Crear incidencia
2. ✅ Solo ver propias incidencias (si está configurado)

---

## 🔒 Cambiar Contraseñas (Opcional)

Para cambiar las contraseñas de los usuarios de prueba:

1. **Acceder como Administrador**

2. **Ir a phpMyAdmin**: http://localhost/phpmyadmin

3. **Seleccionar tabla `usuarios`**

4. **Editar un usuario**

5. **Cambiar hash de contraseña**
   ```php
   // Para cambiar a "MiContraseña123"
   password_hash('MiContraseña123', PASSWORD_BCRYPT)
   ```

6. **Guardar cambios**

---

## 🆘 Troubleshooting

### Error: "No se puede conectar a la base de datos"

**Solución:**
1. Verificar que MySQL está iniciado en XAMPP
2. Verificar que la base de datos `control_operativo_demo` existe
3. Verificar credenciales en `app/config.php`
4. Verificar que el archivo `control_operativo_demo.sql` fue importado

### Error: "Página no encontrada (404)"

**Solución:**
1. Verificar que la carpeta está en: `C:\xampp\htdocs\control-operativo-hospitalario`
2. Verificar URL correcta: `http://localhost/control-operativo-hospitalario/public/`
3. Reiniciar Apache en XAMPP

### Error: "Parse error" o código PHP visible

**Solución:**
1. Verificar que Apache está iniciado
2. Verificar que PHP está habilitado en XAMPP
3. Verificar que los archivos .php tienen extensión correcta

### Error: "Sesión expirada"

**Solución:**
- Es normal después de inactividad
- Volver a iniciar sesión

### Error: "Permiso denegado" al importar SQL

**Solución:**
1. Usar phpMyAdmin en lugar de línea de comandos
2. Verificar permisos del archivo `control_operativo_demo.sql`
3. Intentar importar sin especificar ruta completa

---

## 📋 Checklist de Instalación

- [ ] XAMPP instalado y funcionando
- [ ] Apache iniciado (verde en XAMPP Control Panel)
- [ ] MySQL iniciado (verde en XAMPP Control Panel)
- [ ] Carpeta copiada en `htdocs`
- [ ] Base de datos `control_operativo_demo` creada
- [ ] Archivo SQL importado correctamente
- [ ] phpMyAdmin muestra 3 tablas
- [ ] Archivo `app/config.php` verificado
- [ ] URL accesible: http://localhost/control-operativo-hospitalario/public/
- [ ] Login funciona con datos de prueba
- [ ] Dashboard muestra gráficas

---

## 🎉 ¡Instalación Completada!

La aplicación está lista para usar. Puedes:
- Crear nuevas incidencias
- Filtrar y buscar
- Ver gráficas y estadísticas
- Revisar bitácora de movimientos
- Cambiar roles y permisos

---

## 📞 Soporte

Para problemas o preguntas:
1. Revisar sección de Troubleshooting arriba
2. Verificar logs de Apache: `C:\xampp\apache\logs\error.log`
3. Verificar logs de PHP: `C:\xampp\php\logs\php_errors.log`

---

**Versión**: 1.0.0  
**Última actualización**: 2026-07-08  
**Estado**: Listo para producción

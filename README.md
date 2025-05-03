# Project Manager App

Una aplicación interna construida con **Symfony 6** para una empresa de gestión de proyectos. Permite administrar proyectos, empleados y registrar auditorías de las acciones realizadas en el sistema.

---

## 🌐 Tecnologías y dependencias principales

* Symfony 6 (Full-stack, monolito)
* Doctrine ORM + PostgreSQL
* Twig + Bootstrap 5
* Symfony Security (login con roles)
* Validaciones con Symfony Validator
* Auditoría mediante Event Subscribers

---

## 📅 Requerimientos del sistema

* PHP 8.1+
* Composer
* PostgreSQL
* Symfony CLI (recomendado para desarrollo local)

---

## 🔄 Instalación

1. Clona el repositorio

```bash
 git clone https://github.com/EdgarC97/Reto-1
 cd project_manager
```

2. Instala las dependencias

```bash
 composer install
```

3. Crea la base de datos y ejecuta las migraciones

```bash
 php bin/console doctrine:database:create
 php bin/console doctrine:migrations:migrate
```

4. Corre el servidor de desarrollo

```bash
 symfony server:start
```

---

## 🔑 Usuarios

* El sistema no tiene un registro automático de usuarios admin por defecto por el momento.
* Puedes crear un usuario directamente vía SQL.
* El rol por defecto es `ROLE_USER`, si deseas acceder a toda la administración, necesitas `ROLE_ADMIN`.

---

## 📂 Funcionalidades principales

### Autenticación

* Formulario de login (`/login`)
* Logout funcional
* Redirección al dashboard tras login

### Dashboard

* Navegación hacia:

  * Empleados (`/employee`)
  * Proyectos (`/project`)
  * Auditorías (`/audit`)

### CRUD: Empleados y Proyectos

* Crear, listar, editar y eliminar
* Asignación bidireccional ManyToMany (empleado-proyecto)
* Validaciones de campos (`@Assert`)
* Mensajes de éxito en operaciones

### Auditoría (Auditing)

* Registro automático de CREATE / UPDATE / DELETE en entidades Empleado y Proyecto
* Datos registrados:

  * Usuario que realizó la acción
  * Entidad afectada
  * Tipo de acción
  * Fecha y hora
  * ID de la entidad afectada

---

## 📜 Futuras mejoras

* Autologin tras registro
* Roles con acceso granular (solo ver proyectos, etc)
* Filtros de auditoría
* Tests funcionales
* Paginación y ordenamiento de tablas

---


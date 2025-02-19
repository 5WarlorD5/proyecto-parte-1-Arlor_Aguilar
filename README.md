# Proyecto: Tienda de Ropa

## Descripción del Proyecto

Este proyecto tiene como objetivo la creación de una base de datos robusta para la gestión de una tienda de ropa. La base de datos tiene como principal función manejar las operaciones de ventas, gestión de prendas, marcas y clientes, lo cual facilita el control de inventarios y el seguimiento de las transacciones de la tienda.

### Funcionalidades:

- **Gestión de usuarios**: Administra tanto a empleados como a administradores de la tienda.
- **Gestión de marcas y prendas**: Permite controlar el stock y los precios de las prendas de distintas marcas.
- **Gestión de ventas**: Realiza el seguimiento de las ventas, clientes y productos vendidos.
- **Consultas avanzadas**: Permite realizar consultas dinámicas sobre el estado de ventas, stock y marcas más vendidas.

Este sistema está diseñado para agilizar el manejo de la tienda, asegurando que los datos sean fácilmente accesibles y manejables para mejorar la experiencia tanto de los clientes como del personal.

## Diagrama de la Base de Datos

El diagrama a continuación ilustra cómo están interrelacionadas las tablas dentro de la base de datos para gestionar eficientemente la información de la tienda.

![Diagrama](./proyecto-parte-1-Arlor_Aguilar/assets/diagrama.png "Diagrama de la base de datos")

## Estructura de la Base de Datos

La base de datos está compuesta por las siguientes tablas clave:

- **Usuarios**: Almacena la información de empleados y administradores.
- **Clientes**: Contiene datos de los clientes de la tienda.
- **Marcas**: Registra las marcas de las prendas disponibles.
- **Prendas**: Detalla la información sobre las prendas en stock.
- **Ventas**: Almacena información sobre las transacciones realizadas.
- **Detalle de Ventas**: Guarda el detalle de cada producto vendido en las ventas.

## Consultas

Algunas consultas útiles que se pueden ejecutar para obtener datos clave son:

1. **Cantidad de prendas vendidas por fecha**: Consulta para conocer el volumen de ventas por día.
2. **Marcas con ventas**: Consulta las marcas que han tenido ventas en la tienda.
3. **Top 5 de marcas más vendidas**: Obtén las marcas con mayores ventas.
4. **Prendas vendidas y stock restante**: Consulta el inventario de las prendas más vendidas y su disponibilidad actual.

## Estructura del Repositorio

Este repositorio contiene los siguientes archivos fundamentales:

- **`crear_base_de_datos.sql`**: Script para crear la base de datos y sus tablas esenciales.
- **`insertar_datos.sql`**: Script para insertar datos de ejemplo en las tablas.
- **`consultas.sql`**: Incluye ejemplos de consultas que se pueden realizar en la base de datos.
- **`vistas.sql`**: Script para crear las vistas necesarias para facilitar las consultas.
- **`eliminar_actualizar_datos.sql`**: Script para eliminar o actualizar datos en las tablas cuando sea necesario.

## Integrante del Proyecto

- **Arlor Aguilar**

## Instalación

Para ejecutar este proyecto en tu entorno local, sigue estos pasos:

1. Clona el repositorio en tu máquina local:
   ```bash
   git clone https://github.com/5WarlorD5/proyecto-parte-1-Arlor_Aguilar.git

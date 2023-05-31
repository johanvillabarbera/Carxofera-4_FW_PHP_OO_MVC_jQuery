# CarXofera 🥦

_¿De qué trata Carxofera?_ 

Carxofera es una página web de compra y venta de vehículos de segunda mano, donde el usuario tendrá
la opción de poder navegar por los distintos vehículos existentes e incluso registrarse para poder comprar.

## Contenido 📖

_¿Qué tecnologías se han utilizado?_

📺 Frontend &nbsp;
  ![JavaScript](https://img.shields.io/badge/-JavaScript-333333?style=flat&logo=javascript)
  ![JQuery](https://img.shields.io/badge/jQuery-333333?style=flat&logo=jquery)
  
💻 Backend &nbsp;
  ![PHP](https://img.shields.io/badge/PHP-333333?style=flat&logo=php)
  
🛢 Bases de datos &nbsp;
  ![MySQL](https://img.shields.io/badge/-MySQL-333333?style=flat&logo=mysql)
  
🎨 Diseño &nbsp;
  ![HTML5](https://img.shields.io/badge/-HTML5-333333?style=flat&logo=HTML5)
  ![CSS](https://img.shields.io/badge/-CSS-333333?style=flat&logo=CSS3&logoColor=1572B6)
  ![Bootstrap](https://img.shields.io/badge/Bootstrap-333333?style=flat&logo=bootstrap&logoColor=white) 
  
⚙ IDE &nbsp;
  ![Visual Studio Code](https://img.shields.io/badge/-Visual%20Studio%20Code-333333?style=flat&logo=visual-studio-code&logoColor=007ACC)
 
 <br/>
 
_¿Como está estructurado?_

La web se compone de los siguientes módulos:

1️⃣ __Home__ :

  El módulo principal donde se muestran los siguientes apartados:
  * Carrusel de búsqueda por marcas de coche.
  * Selector de filtro por categoría de coche.
  * Selector de filtro por tipo de motor.
  * Carrusel con los coches más visitados.
  * Listado de revistas relacionadas con coches.
  
2️⃣ __Shop__ :

  El módulo donde se puede visualizar el listado de coches disponibles. Incluye lo siguiente:
  * Listado de los coches almacenados.
  * Selector de filtros por marca, tipo de motor, categoría y color.
  * Opciones como eliminar los filtros aplicados y seleccionar cualquiera de los filtros aplicados anteriormente.
  * Selector de orden por kilómetros, precio y más visitados, tanto ascendente como descendente.
  * Selector de página.
  * Componente de mapa con las ubicaciones de los coches.
  * Opción de Me gusta. Requiere iniciar sesión con un usuario.
  * Botón para ver los detalles de cada coche. Incluye las características de este, opción de Me gusta, opción para añadir unidades al carrito, ubicación en el mapa y listado con los coches relacionados.

3️⃣ __Search__ :

  El módulo que sirve para buscar coches desde cualquier parte de la aplicación web. Incluye lo siguiente:
  * Filtro por marca.
  * Filtro por modelo, dependiendo de la marca seleccionada.
  * Filtro por ciudad, dependiendo de la marca y del modelo seleccionado.

4️⃣ __Login__ :

  El módulo que sirve para poder identificarte con un usuario. Incluye lo siguiente:
  * Opción de iniciar sesión con un nombre de usuario y una contraseña.
  * Opción de registrarse con un nombre de usuario, un correo electrónico y una contraseña. El nombre y el correo no se pueden repetir, y todos los campos deben de cumplir unos requisitos, como la longitud o algunos carácteres especiales.
  * Una vez se ha iniciado sesión, se muestra el nombre del usuario con su avatar y la opción de cerrar sesión.
  * Existen algunas funciones como dar Me gusta o añadir al carrito, las cuales requieren un inicio de sesión.

5️⃣ __Cart__ :

  El módulo que permite añadir al carrito los coches y proceder a la compra de estos. Incluye lo siguiente:
  * Desde la ventana de detalles de un coche, opción para añadir al carrito la cantidad seleccionada. Se requiere inicio de sesión y se tiene en cuenta el stock del coche a la hora de sumar unidades.
  * Una vez añadido al carrito un artículo, se puede acceder a la ventana para visualizar su contenido.
  * Dentro del carrito, se pueden ver los coches añadidos con su imagen (si se hace click en la imagen, se redirige a los detalles del coche), su nombre, su cantidad (se puede actualizar la cantidad desde el propio carrito, con comprobación de stock), su precio y un botón de eliminar del carrito.
  * Precio total del carrito. Si se cambia la cantidad de un coche, se actualiza automáticamente el precio total.
  * Opción de realizar compra. Se actualiza el stock de los coches en la base de datos y se elimina el carrito. 

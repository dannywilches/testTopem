Este repositorio cuenta con la sección del Front-end en VueJS, cuando se descargue se debe ejecutar el comando "npm install" para instalar todas las librerías necesarias.
Una vez instaladas se puede poner a correr el servidor.

Para la sección del Back-end en Laravel en necesario ejecutar el comando "composer install"
Se debe realizar la creación de una base de datos llamada "test_topem" para poder realizar la creación de las tablas.
Una vez creada la Base de Datos se debe ejecutar el comando "php artisan migrate" para la creación de las tablas con sus respectivos relaciones y demás
Es importante ejecutar el comando "php artisan jwt:secret" para generar la clase necesaria para el uso del JWT
Luego de esto se recomienda ejecutar el comadno "php artisan optimize:clear" con el fin de limpiar todo cache y demás para evitar conflictos.
Ya habiendo hecho lo anterior se puede correr el servidor.

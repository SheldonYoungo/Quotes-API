
# Quotes API 📖

API creada como prueba técnica que mediante la API dummyJSON extrae citas de diferentes autores y las muestra en pantalla.

## Tabla de Contenidos 📄
- [Instalación](#instalación)
- [Rutas](#rutas)
- [Pruebas](#pruebas)
- [Consideraciones](#consideraciones)


## Instalación 💨

Para instalar el paquete en tu proyecto de Laravel, copia la url de este repositorio y en tu archivo composer.json añadirás los siguiente:

```
"repositories": {
        "sheldonyoungo/quotes-api-package": {
            "type": "vcs",
            "url" : "https://github.com/SheldonYoungo/Quotes-API.git"
        }
        
    },
```

O en caso de que quieras clonar el repositorio, coloca:
```
"repositories": {
        "sheldonyoungo/quotes-api-package": {
            "type": "path",
            "url" : "[ruta--de-instalacion]/quotes-api-package"
        }
        
    },
```

Una vez hecho esto, abre la terminal y escribe el siguiente comando

```bash
  composer require sheldonyoungo/quotes-api-package
```

Siguiendo estos pasos ya puedes acceder a las rutas del paquete sin ningún problema. Para ver las solo ejecuta el comando `php artisan route:list`

## Rutas 🛫

- `/quotes-ui` Ruta para ver la UI de la aplicación. Solo disponible en ambiente de desarrollo ([click aquí para ver más](#consideraciones)).
- `/api/quotes` Obtiene todas la citas hasta un máximo de 10 por defecto.
    - `?skip={cantidad-a-saltar}` Parametro para saltar cierta cantidad de citas.
    - `?limit={cantidad-a-limitar}` Parametro para limitar la cantidad de citas obtenidas
- `/api/quotes/random` Obtiene una cita aleatoria.
- `/api/quotes/{id}` Obtiene una cita específica en base a su id (número entero positivo). De no conseguirla devuelve un error.


## Pruebas ♻️

Para correr las pruebas del paquete primero se debe clonar el repositorio, luego instalar todas utilizar el comando de la terminal `composer install` y finalmente ejecutar el comando `vendor/bin/pest`.

## Consideraciones 📒


- Si quieres acceder a la vista de la ruta (quotes-ui) es necesario abrir una terminal nueva y ejecutar el siguiente comando `npm run dev` y acceder en el navegador a la ruta `/quotes-ui`.

- En caso de querer modificar la UI del paquete es necesario publicar los assets y la vista principal, esto se logra con el comando:

      ``` bash
          php artisan vendor:publish --tag=views
      ```
  Esto publicará los assets en la ruta `/resources/vendor/quotes-api-package` para que puedan ser modificados.

## Tech Stack 💻

- Laravel
- Vue
- Pest

- Laravel
- Vue.js



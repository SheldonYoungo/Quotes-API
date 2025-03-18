
# 📖 Quotes API

API creada como prueba técnica que mediante la API dummyJSON extrae citas de diferentes autores y las muestra en pantalla.

## 📄 Tabla de Contenidos
- [Instalación](#instalación)
- [Uso](#uso)
- [Contribución](#contribución)
- [Licencia](#licencia)


## 💨 Instalación

Para hacer deploy de esta API primero abre la terminal y  clona el proyecto en  la carpeta que prefieras.

Una vez hecho esto, entra en ella y ejecuta el comando

```bash
  composer install
```

Seguido de esto, instala los node_modules y construye el paquete con los assets de la vista de Vue.js

```bash
  npm install && npm run build
```

Luego de esto asegurate de haber creado el archivo .env con las configuraciones de la app. Se recomienda tomar de ejemplo el .env.example que viene al clonar el repo y luego generar la app_key mediante el comando:

```bash
  php artisan key:generate
```

Una vez hecho este paso, se publica el paquete de Laravel en la carpeta public mediante el comando

```bash
  php artisan vendor:publish --tag=public
```

Y ya está listo para poder hacer el deploy.

```bash
  php artisan serve
```




## 🔒 Variables de entorno

Para correr este proyecto, se necesita agregar las siguiente variables de entorno a tu archivo .env.

`API_BASE_URL` -- Url de la API DummyJSON (https://dummyjson.com/quotes)

`RATE_LIMIT` -- Límite de peticiones al servidor

`RATE_LIMIT_DURATION` -- Ventana de tiempo para recibir peticiones


## 🛫 Rutas

- `/quotes-ui` Ruta para ver la UI de la aplicación.
- `/api/quotes` Obtiene todas la citas hasta un máximo de 10 por defecto.
    - `?skip={cantidad-a-saltar}` Parametro para saltar cierta cantidad de citas.
    - `?limit={cantidad-a-limitar}` Parametro para limitar la cantidad de citas obtenidas
- `/api/quotes/random` Obtiene una cita aleatoria.
- `/api/quotes/{id}` Obtiene una cita específica en base a su id (número entero positivo). De no conseguirla devuelve un error.


## ♻️ Pruebas

Para correr las pruebas basta con utilizar el comando de la terminal

```bash
  php artisan test
```


## 📒 Consideraciones

En caso de querer modificar el frontend . Todos los archivos de las vista se encuentran en la ruta `/resources/js`. Allí encontrarás todos los componentes de la vista.

Si quieres probar la vista en desarrollo basta con ejecutar el comando y acceder a la ruta ya descrita para la UI:

``` bash
    npm run dev
```

Y para publicar los assets del frontend usa el comando:

```bash
    npm run build
```



## 💻 Tech Stack

- Laravel
- Vue.js




# Queue Management

Queue Management es un sistema que sirve para gestionar los tickets de los clientes y los asigna de manera estratégica a las distintas colas y procedimientos que se manejan en la institución tratando de reducir el tiempo de espera de los clientes.

A continuación te mostraré como configurar el sistema "Queue-Management" para su correcto uso.


## Configura el archivo .env

- Clona el archivo ".env.example" y renombralo a ".env".
- Cambia la variable APP_NAME (example: Queue-Management).
- Cambia la variable APP_URL (Si trabajas con servidor local: 127.0.0.1).
- Cambia la variable APP_KEY con el siguiente comando

```bash
php artisan key:generate
```

- Crea una base de datos con el nombre de "queue_management"
- Coloca el nombre de la base de datos y las credenciales en sus respectivas variables de entorno:

`DB_DATABASE=queue_management`

`DB_USERNAME=root`

`DB_PASSWORD=password123`

## Ejecución de Migraciones
Una vez tengas creada tu base de datos y tu archivo .env configurado, debes ejecutar los siguientes comandos:
```bash
php artisan migrate --seed

php artisan shield:install --fresh
```
## Ejecutar la Aplicación

Ubicate en la carpeta de tu proyecto

```bash
  cd queue-management
```

Instala dependencias

```bash
  npm install
```

Construye el proyecto

```bash
  npm run build
```

Compila el proyecto

```bash
  npm run dev
```

## Tecnologias

- [PHP](https://www.php.net/)
- [Laravel](https://laravel.com/)
- [FilamentPHP](https://filamentphp.com/docs/3.x/forms/installation)
- [MySQL](https://www.mysql.com/)

## Authors

- [EminRams](https://www.github.com/EminRams)

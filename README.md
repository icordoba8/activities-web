# web desarrolada en laravel V-8

A continuación, tenemos una secuencia de comnados a utilizar antes de subir el server web

# Instalar dependencias antes de correr el proyecto

```
composer install

```

# Generar .env después de clonar repositorio

```
cp .env.example .env

php artisan key:generate

```

# Agregar variable API_REST aechivo .env

```
Esta el la variable de la api que tomara la plataforma web para las peticiones
el puerto debe ser el mismo que toma la
API_REST = http://127.0.0.1:[PUERTO API]/api

Ejemplo API_REST = http://127.0.0.1:2020/api

```


# Subir serve web

```
php artisan server

```

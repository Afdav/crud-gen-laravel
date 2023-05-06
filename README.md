# Laravel CRUD Generator

**Versión**: 1.0.0

Este paquete proporciona un comando `generate:crud` para Laravel, que genera automáticamente modelos, controladores y vistas a partir de una tabla existente en la base de datos.

## Requisitos

- PHP >= 7.3
- Laravel >= 7.0

## Instalación

Para instalar el paquete, simplemente ejecuta el siguiente comando:

```bash
composer require your-vendor-name/laravel-crud-generator
```
## Configuración

Después de instalar el paquete, debes registrar el proveedor de servicios en tu proyecto Laravel. Abre el archivo `config/app.php` y agrega la siguiente línea al final del arreglo `providers`:

```php
afdav\CrudGeneradorLaravel\LaravelCrudGeneratorServiceProvider::class,
```
Si estás utilizando Laravel 5.5 o superior, el proveedor de servicios se registrará automáticamente a través del descubrimiento de paquetes, por lo que no tendrás que agregarlo manualmente.

## Uso
Para usar el comando `generate:crud`, ejecuta lo siguiente en tu terminal:

```bash
php artisan generate:crud {table}
```

Reemplaza `{table}` con el nombre de la tabla existente en tu base de datos.

El comando creará automáticamente el modelo, controlador y vistas (index, create, show, edit) correspondientes a la tabla especificada y agregará las rutas necesarias al archivo `routes/web.php`.

## Contribución
Las contribuciones son bienvenidas. Siéntete libre de enviar pull requests o crear issues para reportar problemas o solicitar nuevas características.

## Licencia
Este paquete está licenciado bajo la licencia MIT.
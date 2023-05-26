# Hiring-API
Powered by Adal

![Build Status](https://media.licdn.com/dms/image/C5112AQH818MFMFB7mQ/article-cover_image-shrink_720_1280/0/1585606142632?e=2147483647&v=beta&t=YwbdtbEycCQUtL-d71oZUbRht1A92AKM1c1c2zqpyxQ)

Esta API permite gestionar un sistema de reclutamiento, en la cual se pueden crear candidatos y obtener su información.

## Características

- Desarrollada con PHP 8.1 y Laravel 9
- Uso de Docker
- Testing con PHPUnit
- Cache con Redis
- Auth con JWT
- Documentación con Swagger UI

## Correr el proyecto localmente
1. Debes tener docker y docker compose instalados en tu máquina. Abre tu consola de preferencia en el directorio que quieras tener el proyecto, en este ejemplo será el directorio Downloads, procedemos a clonar el proyecto e ingresar en el directorio.

    ```sh
    cd Downloads
    git clone https://github.com/Adal1013/hiring-api
    cd hiring-api
    ```

2. Una vez estes dentro de la raiz del proyecto (hiring-api) ejecuta una unica vez el siguiente comando:

    ```sh
    sh setup-local.sh
    ```

3. Ya con esto tendrás el proyecto corriendo en tu máquina local en el puerto :8001. Si deseas ejecutar las pruebas lo puedes hacer desde la consola con el siguiente comando:

    ```sh
    docker exec -it hiring-api php artisan test
    ```
    
4. Puedes ingresar a la documentación de la API y hacer pruebas desde allí, a traves de la siguiente ruta: `http://localhost:8001/api/documentation`
    
5. En la carpeta insomnia que se encuentra sobre la raiz del proyecto encontraras una coleción para importar en insomnia.

6. Dado que el setup-local.sh se ejecuta la primera vez solamente, siempre que desees iniciar el proyecto nuevamente lo puedos hacer a traves del archivo start-local.sh, desde tu consola ejectuta el siguiente comando: 

    ```sh
    sh start-local.sh
    ```

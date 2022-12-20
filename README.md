# SmartCityStation

Nuevas funcionalidades desarrolladas en coejecución Heidy - Alberto

**Original repository**
https://gitlab.com/tecnoparquerionegro1/smartcitystationdos.git

# How to deploy in local

1. Crear la base de datos.
2. Clonar el archivo .env.example y eliminar la extension .example
3. Del archivo .env Escribir los datos solicitados en la líneas:
 * **Database**
 * **Access:** pasar a false la autenticación de dos factores.

Una vez hecho estos pasos hacer los siguientes comando con tu terminal git, cmd o la terminal visual.

1. **composer install**
2. **npm install**
3. **php artisan migrate**
4. **php artisan db:seed**
5. **php artisan key:generate**
6. **npm run dev**
7. **php artisan storage:link**

# Libraries to install

* **Laravel excel:** composer require maatwebsite/excel
* **Laravel backup:** composer require spatie/laravel-backup
* **Laravel googlMapper:** Agregar en composer.json "cornford/googlmapper": "3.*"

Hacer composer update

**Agregar en archivo app.php seccion Provider:**

* Maatwebsite\Excel\ExcelServiceProvider::class,

* Spatie\Backup\BackupServiceProvider::class, 

* Cornford\Googlmapper\MapperServiceProvider::class,

**Luego publicamos en config con los siguientes comandos:**

* php artisan vendor:publish --provider="Maatwebsite\Excel\ExcelServiceProvider" --tag=config
* php artisan vendor:publish --provider="Spatie\Backup\BackupServiceProvider"
* php artisan vendor:publish -- provider="Cornford\Googlmapper\MapperServiceProvider" --tag=googlmapper

# Store Procedures to use


**Get measures date**

DELIMITER //
        CREATE PROCEDURE SP_GetMeasures(	
            IN idVar INT, 
            IN startDate DATE, 
            IN endDate DATE,
            IN deviceId INT
        )
        BEGIN
           WITH measuresCTE AS (
                SELECT M.time, M.data
                    FROM measures AS M 
                    WHERE DATE(M.time) BETWEEN startDate AND endDate AND M.data_variable_id = idVar AND M.device_id = deviceId
                )      
        SELECT * FROM measuresCTE
DELIMITER ;

**Get measures same day**

CREATE PROCEDURE SP_GetMeasuresSameDay(	
            IN idVar INT, 
    		IN startDate DATE, 
    		IN startTime TIME,
    		IN endTime TIME,
    		IN deviceId INT
        )
        BEGIN
              WITH measuresCTE AS (
                SELECT M.time, M.data
                    WHERE TIME(M.time) BETWEEN startTime AND endTime AND M.data_variable_id = idVar AND DATE(M.time) = startDate AND M.device_id = deviceId
                )      
        SELECT * FROM measuresCTE;
END;

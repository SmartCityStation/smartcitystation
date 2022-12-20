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
        END;
DELIMITER ;

**Get measures same day**

DELIMITER //
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
DELIMITER ;


# Link APIS Postman

**Headers**

* **Key:** content-Type
* **Value:** application/json
* **Type:** POST


**recordMeasures:** http://smartcitystation.com/api/frontend/recordmeasures

JSON **[{"device":"DEV_001","variable":"LAeq", "data":[
    {"time":"2022-12-13 11:41:01","value":23.4}
}]**

**recordambientalData:** http://smartcitystation.com/api/frontend/recordambientaldata

JSON **[{"device":"DEV_001",
 "data":
[{"time":"2022-10-08 08:31:00",
"temp":26.6,
"hum":56.4,
"presion":64.5}]}]**

**recordOctaveBand:** http://smartcitystation.com/api/frontend/recordoctaveband

JSON **[
    {
        "device":"DEV_001",
        "data":[{
            "time":"2022-10-07 15:30",
            "lp":[
            50.6,
            80.0,
            65.4,
            78.3,
            80.6,
            78.8,
            76.6,
            75.4,
            75.2,
            74.9,
            74.7,
            74.6,
            73.4,
            72.5,
            73.5,
            71.8,
            70.2,
            69.6,
            72.5,
            73.4,
            73.5,
            71.8,
            68,
            68.3,
            67,
            66.5,
            66.4,
            66.7,
            67,
            73.8 
            ]
        }]
    }
]**

**recordLocation:** http://smartcitystation.com/api/backend/recordlocation

JSON **[{"codigo_dispositivo": "DEV_001", "Direccion": "Cl. 17A Sur #N°48-94 Interior 418", "Fecha_ins": "2021-12-03", "Hora_ins": "11:05:01", "Latitud": "6.1899564", "Longitud": "-75.5820056", "Area": "Poblado", "nombre_proyecto":"Prueba proyecto"}]** 

**recordMaterialParticulated:** http://smartcitystation.com/api/frontend/recordmaterialparticulated

JSON **[{"device":"DEV_001", "data":[{"time":"2022-08-10 08:31:00",
"PM 10": 45,
"PM 2.5": 23}]
}]**



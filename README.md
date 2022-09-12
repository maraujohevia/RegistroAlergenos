# Registro de Alérgenos

## _Descripción general_
Se ha desarrollado una Aplicación en Yii2 y MySQL para dar soporte a la API rest que proporciona las siguientes funcionalidades:
- Obtener los alérgenos de un plato dado
- Obtener los platos en los que aparece un alérgeno en concreto
- Añadir alérgenos
- Añadir ingredientes
- Añadir platos
- Ver la lista completa de platos
- Ver la lista de ingredientes de un plato

Para poder aprovecharse de estas funcionalidades, se pueden realizar las siguientes llamadas a la API Rest:
### Plato 
- **GET** Mostrar la lista de platos: http://localhost:8080/api/plato
- **POST** Agregar un plato proporcionándo solo su nombre: http://localhost:8080/api/plato
- **POST** Agregar un plato proporcionando una lista de ingredientes. Se puede además incluir los alérgenos de cada ingrediente:  http://localhost:8080/api/plato/agregar-con-ingredientes
- **GET** Mostrar la lista de alérgenos de un plato: http://localhost:8080/api/plato/ver-alergenos?nombrePlato=[Nombre del Plato]

### Ingrediente
- **GET** Mostrar la lista de ingredientes existente: http://localhost:8080/api/ingrediente
- **POST** Agregar un ingrediente a la lista: http://localhost:8080/api/ingrediente
- **GET** Mostrar los alérgenos de un ingrediente: http://localhost:8080/api/ingrediente/ver-alergenos?nombreIngrediente=[Nombre del ingrediente]
- **GET** Mostrar la lista de platos que contienen un ingrediente: http://localhost:8080/api/ingrediente/ver-platos?nombreIngrediente=[Nombre del ingrediente]

### Alérgeno
- **GET** Mostar la lista de alérgenos: http://localhost:8080/api/alergeno
- **POST** Crear alérgeno: http://localhost:8080/api/alergeno
- **GET** Mostrar la lisa de platos que contienen un alérgeno dado: http://localhost:8080/api/alergeno/ver-platos?nombreAlergeno=[Nombre del alérgeno]


## _Detalles de la Implementación_
- Se ha creado la ruta `module\api\controllers`, donde se han incluido los controladores específicos de la Api, de manera que estén separados del resto de controladores de la aplicación. Esto constituiría la capa más externa de la Aplicación.
- Se ha creado la ruta `module\casosuso`con las clases que dan soporte a las distintas funciones de Casos de Uso. En las clases de este módulo se ha evitado la utilización de llamada a otros Controladores, así como el uso de la base de datos.
- Las clases del Modelo se han dejado bajo la ruta estándar `models`.
- Esta estructura de clases pretende dar soporte a las distintas capas de la aplicación, para dar así un mayor desacoplamiento que favorezca el mantenimiento en el futuro.
- Se ha utilizado enlace de parametros (Binding Values) al realizar las consultas SQL para evitar posibles ataques de SQL Injection.
- Se ha utilizado ActiveController para generar el CRUD de todos los elementos, pero si por seguridad se deseara limitar su uso, se puede hacer desde la configuración en web.php. NOTA: se ha deshabilitado la pluralización de las rutas.

## _BONUS_
Diseña y, si puedes, implementa un sistema para que quede un registro de cambios sobre los platos.
Para guardar un registro de esos cambios sería interesante:
- El Plato que se cambió
- Qué acción se realizó. ¿Se quitó un ingrediente? ¿Se añadió otro ingrediente?
- Registrar qué ingrediente se añadió o se quitó al Plato. Aquí es importante que si se elimina un ingrediente de un plato, no se elimine de la base de datos, ya que de lo contrario, perderíamos el registro asociado y por tanto la trazabilidad del cambio.
- Fecha y hora en la que se produjo el cambio

## _Puntos de mejora_
- Cambiar el nombre de usuario de administración de la Base de Datos
- Encriptar la contraseña del usuario de la base de datos

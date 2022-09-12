<?php

use Codeception\Util\HttpCode;


/**
 * Inherited Methods
 * @method void wantToTest($text)
 * @method void wantTo($text)
 * @method void execute($callable)
 * @method void expectTo($prediction)
 * @method void expect($prediction)
 * @method void amGoingTo($argumentation)
 * @method void am($role)
 * @method void lookForwardTo($achieveValue)
 * @method void comment($description)
 * @method \Codeception\Lib\Friend haveFriend($name, $actorClass = NULL)
 *
 * @SuppressWarnings(PHPMD)
*/
class FunctionalTester extends \Codeception\Actor
{
    use _generated\FunctionalTesterActions;

    /**
     * Función que permite probar si el Objeto correspondiente a la Clase indicado como parametro se crea correctamente
     * al realizar la petición POST
     * @param FunctionalTester $I
     * @param $nombreClase Nombre de la clase que se desea probar
     * @param $nombreElementoCrear Valor correspondiente a la propiedad nombre del Objeto a crear.
     * @return void
     */
    public function crearCorrectamente(FunctionalTester $I, $nombreClase, $nombreElementoCrear){
        $I->sendPost($nombreClase, [
            'nombre' => $nombreElementoCrear
        ]);
        $I->seeResponseCodeIs(HttpCode::CREATED);
        $I->seeResponseIsJson();
        $I->seeResponseMatchesJsonType([
            'nombre' => 'string',
        ]);
        $I->seeResponseContainsJson(['nombre' => $nombreElementoCrear]);
    }

    /**
     * Función que permite comprobar si se lanza el error correspondiete si al crear un Objeto no se proporciona su Json
     * @param FunctionalTester $I
     * @param $nombreClase Nombre de la clase que se desea Probar
     * @return void
     */
    public function crearSinDarJson(FunctionalTester $I, $nombreClase){
        $I->sendPost($nombreClase, []);
        $I->seeResponseCodeIs(422);
        $I->seeResponseIsJson();
        $I->seeResponseMatchesJsonType([
            'field' => 'string',
            'message' => 'string'
        ]);
        $I->seeResponseContainsJson([
            'field' => 'nombre',
            'message' => 'Nombre cannot be blank.'
        ]);
    }

    /**
     * Función que permite probar que no se puedan crear dos objetos con el mismo valor de su propiedad nombre
     * @param FunctionalTester $I
     * @param $nombreClase Nombre de la clase a probar
     * @param $nombreElementoCrear Valor del nombre del objeto a crear
     * @return void
     */
    public function crearConNombreYaExistente(FunctionalTester $I, $nombreClase, $nombreElementoCrear){
        $I->sendPost($nombreClase, [
            'nombre' => $nombreElementoCrear
        ]);
        $I->sendPost($nombreClase, [
            'nombre' => $nombreElementoCrear
        ]);
        $I->seeResponseCodeIs(422);
        $I->seeResponseIsJson();
        $I->seeResponseMatchesJsonType([
            'field' => 'string',
            'message' => 'string'
        ]);
        $I->seeResponseContainsJson([
            'field' => 'nombre',
            'message' => 'Nombre "'. $nombreElementoCrear .'" has already been taken.'
        ]);
    }

    /**
     * Función que agrega un Plato con sus Ingredientes y Alérgenos para realizar pruebas.
     * @param FunctionalTester $I
     * @return void
     */
    public function agregarPlatoConAlergenosParaPruebas(FunctionalTester $I){
        $I->sendPost('plato/agregar-con-ingredientes', [
            'nombre' => "Tarta de Almendra",
            'ingredientes' => [
                [
                    'nombre' => 'Huevo',
                    'alergenos' => [
                        ['nombre' => 'Huevo']
                    ]
                ],
                ['nombre' => 'Azucar'],
                [
                    'nombre' => 'Almendra',
                    'alergenos' => [
                        ['nombre' => 'Frutos de cáscara']
                    ]
                ],
                ['nombre' => 'Limon'],
                ['nombre' => 'Canela']
            ]
        ]);
    }

    /**
     * Función que agrega varios Platos con sus Ingredientes y Alérgenos para realizar las Pruebas.
     * @param FunctionalTester $I
     * @return void
     */
    public function agregarVariosPlatosConAlergenosParaPruebas(FunctionalTester $I){
        $I->agregarPlatoConAlergenosParaPruebas($I);
        $I->sendPost('plato/agregar-con-ingredientes', [
            'nombre' => "Tarta de Queso",
            'ingredientes' => [
                [
                    'nombre' => 'Galletas',
                    'alergenos' => [
                        ['nombre' => 'Gluten']
                    ]
                ],
                ['nombre' => 'Azucar'],
                [
                    'nombre' => 'Cuajada',
                    'alergenos' => [
                        ['nombre' => 'Lactosa']
                    ]
                ],
                ['nombre' => 'Mantequilla'],
                [
                    'nombre' => 'Queso de untar',
                    'alergenos' => [
                        ['nombre' => 'Lactosa']
                    ]
                ]
            ]
        ]);
        $I->sendPost('plato/agregar-con-ingredientes', [
            'nombre' => "Bizcocho",
            'ingredientes' => [
                [
                    'nombre' => 'Harina',
                    'alergenos' => [
                        ['nombre' => 'Gluten']
                    ]
                ],
                ['nombre' => 'Azucar'],
                [
                    'nombre' => 'Yogur',
                    'alergenos' => [
                        ['nombre' => 'Lactosa']
                    ]
                ],
                ['nombre' => 'Mantequilla'],
                [
                    'nombre' => 'Huevo',
                    'alergenos' => [
                        ['nombre' => 'Huevo']
                    ]
                ],
                ['nombre' => 'Aceite']
            ]
        ]);
    }
}

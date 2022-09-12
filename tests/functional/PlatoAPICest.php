<?php

namespace Functional;

use \FunctionalTester;

class PlatoAPICest
{
    public function _before(FunctionalTester $I)
    {
    }

    /**
     * Prueba caso Satisfactorio: POST http://localhost:8080/api/plato
     * @param FunctionalTester $I
     * @return void
     */
    public function crearPlatoCorrectamente(FunctionalTester $I){
        $I->crearCorrectamente($I, 'plato', 'Tarta de Almendra');
    }

    /**
     * Prueba que se devuelva un Json de error al intentar crear un Plato sin proporcionar su Json.
     * @param FunctionalTester $I
     * @return void
     */
    public function crearPlatoSinDarJson(FunctionalTester $I){
        $I->crearSinDarJson($I, 'plato');
    }

    /**
     * Prueba que se devuelva un Json de error al intentar crear un Plato con un nombre que ya exista previamente.
     * @param FunctionalTester $I
     * @return void
     */
    public function crearPlatoConNombreYaExistente(FunctionalTester $I){
        $I->crearConNombreYaExistente($I, 'plato', 'Tarta de Almendra');
    }

    /**
     * Prueba que se crea satisfactoriamente un Plato proporcionando un Json que incluye los ingredientes del Plato.
     * @param FunctionalTester $I
     * @return void
     */
    public function crearPlatoConIngredientes(FunctionalTester  $I){
        $I->sendPost('plato/agregar-con-ingredientes', [
            'nombre' => "Tarta de Almendra",
            'ingredientes' => [
                ['nombre' => 'Huevo'],
                ['nombre' => 'Azucar'],
                ['nombre' => 'Almendra'],
                ['nombre' => 'Limon'],
                ['nombre' => 'Canela']
            ]
		]);

        $I->seeResponseCodeIsSuccessful();
        $I->seeResponseIsJson();
        $I->seeResponseMatchesJsonType([
            'nombre' => 'string',
        ]);
        $I->seeResponseContainsJson(['nombre' => 'Tarta de Almendra']);
    }

    /**
     * Prueba que se crea satisfactoriamente un Plato, proporcionando un Json con sus ingredientes y
     * sus correspondientes Alergenos
     * @param FunctionalTester $I
     * @return void
     */
    public function crearPlatoConIngredientesAlergenos(FunctionalTester $I){
        $I->agregarPlatoConAlergenosParaPruebas($I);
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $I->seeResponseMatchesJsonType([
            'nombre' => 'string',
        ]);
    }

    /**
     * Prueba que se proporciona correctamente la lista de Alérgenos de un Plato.
     * @param FunctionalTester $I
     * @return void
     */
    public function verAlergenos(FunctionalTester $I){
        $I->agregarPlatoConAlergenosParaPruebas($I);

        $I->sendGet('plato/ver-alergenos?nombrePlato=Tarta de Almendra');
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();

        $I->seeResponseMatchesJsonType([
            'nombre' => 'string',
            'nombre' => 'string'
            ]);

        $I->seeResponseContainsJson(
            ['nombre' => 'Huevo'],
            ['nombre' => 'Frutos de cáscara']
        );
    }


    /**
     * Prueba que se proporcione toda la lista de Platos.
     * @param FunctionalTester $I
     * @return void
     */
    public function getPlatos(FunctionalTester $I){
        $I->sendGet('plato');
        $I->seeResponseCodeIs(http_response_code(200));
        $I->seeResponseIsJson();
        //$I->seeResponseIsValidOnJsonSchema('{"type":"object"}');
        $validResponseJsonSchema = json_encode([
            'properties' => [
                'name' => ['type' => 'string']
            ]
        ]);
        $I->seeResponseIsValidOnJsonSchemaString($validResponseJsonSchema);
    }

    // tests
    public function tryToTest(FunctionalTester $I)
    {
    }
}
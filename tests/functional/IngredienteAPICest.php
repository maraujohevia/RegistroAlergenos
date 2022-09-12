<?php

namespace functional;

use \FunctionalTester;

class IngredienteAPICest
{
    public function _before(FunctionalTester $I)
    {
    }

    /**
     * Prueba que se crea satisfactoriamente un Ingrediente.
     * @param FunctionalTester $I
     * @return void
     */
    public function crearIngredienteCorrectamente(FunctionalTester $I){
        $I->crearCorrectamente($I, 'ingrediente', 'Cebolla');
    }

    /**
     * Prueba que se devuelve un Json con un mensaje de error al intentar crear un Ingrediente sin proporcionar un Json
     * @param FunctionalTester $I
     * @return void
     */
    public function crearIngredienteSinDarJson(FunctionalTester $I){
        $I->crearSinDarJson($I, 'ingrediente');
    }

    /**
     * Prueba que se devuelve un Json con un mensaje de error al intentar crear un Ingrediente cuyo nombre ya existe
     * previamente.
     * @param FunctionalTester $I
     * @return void
     */
    public function crearIngredienteConNombreYaExistente(FunctionalTester $I){
        $I->crearConNombreYaExistente($I, 'ingrediente', 'Cebolla');
    }

    /**
     * Prueba: http://localhost:8080/api/ingrediente/ver-alergenos?nombreIngrediente=Almendra
     * @param FunctionalTester $I
     * @return void
     */
    public function verAlergenos(FunctionalTester $I){
        $I->agregarVariosPlatosConAlergenosParaPruebas($I);
        $I->sendGet('ingrediente/ver-alergenos?nombreIngrediente=Almendra');
        $I->seeResponseCodeIs(http_response_code(200));
        $I->seeResponseIsJson();
        $I->seeResponseMatchesJsonType([
            'nombre' => 'string'
        ]);

        $I->seeResponseContainsJson(
            ['nombre' => 'Frutos de cáscara']
        );
    }

    /**
     * Prueba que dado el nombre de un Ingrediente, se proporcione un Json con todos los Platos que lo contienen.
     * @param FunctionalTester $I
     * @return void
     */
    public function verPlatos(FunctionalTester $I){
        $I->agregarVariosPlatosConAlergenosParaPruebas($I);
        $I->sendGet('ingrediente/ver-platos?nombreIngrediente=Azucar');
        $I->seeResponseCodeIs(http_response_code(200));
        $I->seeResponseIsJson();
        $I->seeResponseMatchesJsonType([
            'nombre' => 'string'
        ]);

        $I->seeResponseContainsJson(
            ['nombre' => 'Tarta de Almendra'],
            ['nombre' => 'Tarta de Queso'],
            ['nombre' => 'Bizcocho']
        );
    }

}
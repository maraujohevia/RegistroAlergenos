<?php

use \FunctionalTester;

class AlergenoAPICest
{

    public function _before(FunctionalTester $I)
    {
    }

    /**
     * Prueba que se crea satisfactoriamente un Alérgeno.
     * @param \FunctionalTester $I
     * @return void
     */
    public function crearAlergenoCorrectamente(FunctionalTester $I){
        $I->crearCorrectamente($I, 'alergeno', 'Cacahuete');
    }

    /**
     * Prueba que se devuelve un Json con un mensaje de error al intentar crear un Alergeno sin proporcionar un Json con
     * su información.
     * @param \FunctionalTester $I
     * @return void
     */
    public function crearIngredienteSinDarJson(FunctionalTester $I){
        $I->crearSinDarJson($I, 'alergeno');
    }

    /**
     * Prueba que se devuelve un Json con un mensaje de error al intentar crear un Alérgeno con un nombre que ya existe
     * previamente.
     * @param \FunctionalTester $I
     * @return void
     */
    public function crearAlergenoConNombreYaExistente(FunctionalTester $I){
        $I->crearConNombreYaExistente($I, 'alergeno', 'Cacahuete');
    }

    /**
     * Prueba que dado un Alérgeno, se proporcionen todos los platos que lo contienen.
     * @param FunctionalTester $I
     * @return void
     */
    public function verPlatosContienenAlergeno(FunctionalTester $I){
        $I->agregarPlatoConAlergenosParaPruebas($I);

        $I->sendGet('alergeno/ver-platos?nombreAlergeno=Huevo');
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $I->seeResponseMatchesJsonType([
            'nombre' => 'string',
        ]);
        $I->seeResponseContainsJson(
            ['nombre' => 'Tarta de Almendra']
        );
    }

}
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

}
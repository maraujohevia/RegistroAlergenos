<?php

namespace app\modules\casosuso;

use app\models\Ingrediente;

class CasosUsoPlato
{

    /**
     * Función que, dado un Plato y un Array de nombres de Ingredientes, crea los ingredientes correspondientes y los
     * asocia al Plato pasado como parámetro.
     * @param $plato Plato al cual se quieren agregar Ingredientes.
     * @param $ingredientes Array con los nombres de Ingredientes que se quieren agregar al Plato.
     * @return void
     */
    public function agregarIngredientes($plato, $ingredientes){
        foreach ($ingredientes as $ingredienteJson) {
            $nombreIngrediente = $ingredienteJson['nombre'];
            $ingrediente = Ingrediente::find()
                ->where(['nombre' => $nombreIngrediente])
                ->one();

            if ($ingrediente == null) {
                $ingrediente = new Ingrediente();
                $ingrediente->setAttribute('nombre', $ingredienteJson['nombre']);
                $ingrediente->save();
            }

            $plato->link('ingredientes', $ingrediente);

            if (array_key_exists('alergenos', $ingredienteJson)) {
                $alergenos = $ingredienteJson['alergenos'];

                $casoUsoIngrediente = new CasosUsoIngrediente();
                $casoUsoIngrediente->agregarAlergenos($ingrediente, $alergenos);
            }
        }
    }
}
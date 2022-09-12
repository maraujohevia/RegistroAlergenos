<?php

namespace app\modules\casosuso;

use app\models\Alergeno;

class CasosUsoIngrediente
{

    /**
     * Función que, dado un Ingrediente y un Array de nombres de Alérgeno, crea los Alérgenos correspondientes y los
     * asigna al Ingrediente
     * @param $ingrediente Ingrediente al cual se quieren agregar los Alérgenos.
     * @param $alergenos Array de Alergenos que se desea crear y añadir al Ingrediente.
     * @return void
     */
    public function agregarAlergenos($ingrediente, $alergenos){
        foreach ($alergenos as $alergenoArray) {
            $alergeno = new Alergeno();
            $alergeno->setAttribute('nombre', $alergenoArray['nombre']);
            if ($alergeno->validate()) {
                $alergeno->save();
                $ingrediente->link('alergenos', $alergeno);
            }
        }
    }

}
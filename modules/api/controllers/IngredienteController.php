<?php

namespace app\modules\api\controllers;

use yii\rest\ActiveController;
use app\models\Ingrediente;

class IngredienteController extends ActiveController
{
    //Variable para enlazar ActiveController con su correspondiente modelo
    public $modelClass = Ingrediente::class;

    /**
     * Función que devuelve los Alérgenos de un Ingrediente
     * @param $nombreIngrediente Nombre del Ingrediente del cual se quieren obtener sus Alérgenos.
     * @return mixed|null
     */
    public function actionVerAlergenos($nombreIngrediente){
        $Ingrediente = Ingrediente::findOne(['nombre' => $nombreIngrediente]);
        return $Ingrediente->alergenos;
    }

    /**
     * Función que devuelve los Platos en los que se puede encontrar el Ingrediente que se pasa como parámetro.
     * @param $nombreIngrediente Nombre del Ingrediente del cual se quieren obtener los platos en los que se utiliza.
     * @return mixed|null
     */
    public function actionVerPlatos($nombreIngrediente){
        $Ingrediente = Ingrediente::findOne(['nombre' => $nombreIngrediente]);
        return $Ingrediente->platos;
    }

}
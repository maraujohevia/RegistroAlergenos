<?php

namespace app\modules\api\controllers;

use app\models\Alergeno;
use yii\rest\ActiveController;

class AlergenoController extends ActiveController
{
    //Variable para enlazar ActiveController con su correspondiente modelo
    public $modelClass = Alergeno::class;

    /**
     * Función que devuelve los Platos que contienen el Alérgeno que se pasa como parámetro.
     * @param $nombreAlergeno Nombre del Plato del cual se desean obtener sus Alérgenos.
     * @return array|\yii\db\ActiveRecord[]
     */
    public function actionVerPlatos($nombreAlergeno){
        return Alergeno::find()
            ->select('plato.nombre')
            ->innerJoinWith('ingredientes')
            ->innerJoin('{{%plato_ingrediente}}', 'plato_ingrediente.ingrediente_id = ingrediente.id')
            ->innerJoin('{{%plato}}', '{{%plato_ingrediente.plato_id}} = {{%plato.id}}')
            ->where('{{%alergeno.nombre}} = :nombreAlergeno',
                [ 'nombreAlergeno' => $nombreAlergeno ]
            )->all();
    }
}
<?php

namespace app\modules\api\controllers;

use app\models\Plato;
use app\models\Alergeno;
use app\modules\casosuso\CasosUsoPlato;

use yii\rest\ActiveController;

class PlatoController extends ActiveController
{
    //Variable para enlazar ActiveController con su correspondiente modelo
    public $modelClass = Plato::class;

    /**
     * Función que devuelve los Ingredientes de un Plato
     * @param $nombrePlato Nombre del Plato del cual se desean saber sus Ingredientes
     * @return mixed|null Ingredientes del nombre del Plato pasado como parámetro.
     */
    public function actionVerIngredientes($nombrePlato){
        $plato = Plato::findOne(['nombre' => $nombrePlato]);
        return $plato->ingredientes;
    }

    /**
     * Función que devuelve los Alérgenos de un Plato
     * @param $nombrePlato Nombre del Plato del cual se quieren obtener sus Alérgenos.
     * @return array|\yii\db\ActiveRecord[]
     */
    public function actionVerAlergenos($nombrePlato){
        return Alergeno::find()
            ->select('alergeno.nombre')
            ->innerJoinWith('ingredientes')
            ->innerJoin('{{%plato_ingrediente}}', '{{%plato_ingrediente.ingrediente_id}} = {{%ingrediente.id}}')
            ->innerJoin('{{%plato}}', '{{%plato_ingrediente.plato_id}} = {{%plato.id}}')
            ->where('{{%plato.nombre}} = :nombrePlato',
                [
                    'nombrePlato' => $nombrePlato
                ]
            )->all();
    }

    /**
     * Función que permite agregar un Plato con sus Ingredientes.
     * @return Plato|Mensaje
     */
    public function actionAgregarConIngredientes(){
        $json = \Yii::$app->request->post();
        $nombrePlato = $json['nombre'];

        //Buscamos si ese nombre de Plato ya existe
        $plato = Plato::find()
            ->where(['nombre' => $nombrePlato])
            ->one();

        //Si el plato no existe
        if($plato == null) {
            //Si nos han proporcionado lista de ingredientes
            if (array_key_exists('ingredientes', $json)) {

                //Guardamos el plato
                $plato = new Plato();
                $plato->setAttribute('nombre', $json['nombre']);
                $plato->save();

                //Procesamos la lista de ingredientes
                $ingredientes = $json['ingredientes'];

                $casoUsoPlato = new CasosUsoPlato();
                $casoUsoPlato->agregarIngredientes($plato, $ingredientes);

            } else {
                return $this->errorResponse("Lista de ingredientes no proporcionada", 422);
            }
        } else{
            return $this->errorResponse("El plato ya existe");
        }
        return $plato;
    }

    /**
     * Función que devuelve en formato Json el mensaje de error que se le pasa como parámetro.
     * @param $mensaje Mensaje de Error que se desea devolver
     * @return Mensaje de error en formato Json
     */
    private function errorResponse($mensaje, $statusCode=400){
        \Yii::$app->response->statusCode = $statusCode;
        return $this->asJson(['error' => $mensaje]);
    }
}
<?php

namespace app\models;

use yii\db\ActiveRecord;


class Plato extends ActiveRecord
{
    /**
     * Funcion que devuelve las propiedades del Plato que se mostrarán por defecto.
     * @return string[] Array con las propiedades del Plato que se mostrarán por defecto
     */
    public function fields(){
        return ['nombre'];
    }

    /**
     * Función que devuelve las propiedades adicionales del Plato que se pueden mostrar.
     * @return string[] Array con las propiedades extra del Plato que se pueden mostrar.
     */
    public function extraFields(){
        return ['ingredientes'];
    }

    /**
     * Función que devuelve los Ingredientes de un Plato.
     * @return \yii\db\ActiveQuery
     * @throws \yii\base\InvalidConfigException
     */
    public function getIngredientes(){
        return $this->hasMany(Ingrediente::class, ['id' => 'ingrediente_id'])
            ->viaTable('plato_ingrediente', ['plato_id' => 'id']);
    }

    /**
     * Función que devuelve los Alérgenos que hay en un Plato.
     * @return \yii\db\ActiveQuery
     */
    public function getAlergenos(){
        return $this->hasMany(Alergeno::class, ['id' => 'alergeno_id'])->via('ingredientes');
    }

    /**
     * Función en la que se establecen las reglas que deben cumplir las propiedades del Plato.
     * @return array Array con las reglas de las propiedades del Plato.
     */
    public function rules()
    {
        return [
            [['nombre'], 'required'],
            [['nombre'], 'string', 'max' => 50],
            [['nombre'], 'unique'],
        ];
    }
}
<?php

namespace app\models;

use yii\db\ActiveRecord;

class Ingrediente extends ActiveRecord
{
    /**
     * Función que devuelve qué propiedades del Ingrediente se mostrarán por defecto.
     * @return string[] Array con las propiedades del Ingrediente que se mostrarán por defecto.
     */
    public function fields(){
        return ['nombre'];
    }

    /**
     * Función que devuelve las propiedades extra del Ingrediente que se pueden mostrar.
     * @return string[]  Array con las propiedades extra que se pueden mostrar del ingrediente.
     */
    public function extraFields(){
        return ['alergenos', 'platos'];
    }

    /**
     * Función que devuelve los Platos que se pueden elaborar con el Ingrediente
     * @return \yii\db\ActiveQuery
     * @throws \yii\base\InvalidConfigException
     */
    public function getPlatos(){
        return $this->hasMany(Plato::class, ['id' => 'plato_id'])
            ->viaTable('plato_ingrediente', ['ingrediente_id' => 'id']);
    }

    /**
     * Función que devuelve los Alérgenos que tiene el Ingrediente
     * @return \yii\db\ActiveQuery
     * @throws \yii\base\InvalidConfigException
     */
    public function getAlergenos(){
        return $this->hasMany(Alergeno::class, ['id' => 'alergeno_id'])
            ->viaTable('ingrediente_alergeno', ['ingrediente_id' => 'id']);
    }

    /**
     * Función en la que se establecen las reglas que deben cumplir las propiedades del Ingrediente.
     * @return array Array con las reglas de las propiedades del Ingrediente
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
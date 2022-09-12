<?php

namespace app\models;

use yii\db\ActiveRecord;

class Alergeno extends ActiveRecord
{
    /**
     * Funcion que devuelve las propiedades del Alergeno se mostrarán por defecto.
     * @return string[] Array con las propiedades del Alérgeno que se mostrarán por defecto
     */
    public function fields(){
        return ['nombre'];
    }

    /**
     * Función que devuelve los ingredientes que contienen el Alergeno.
     * @return \yii\db\ActiveQuery
     * @throws \yii\base\InvalidConfigException
     */
    public function getIngredientes()
    {
        return $this->hasMany(Ingrediente::class, ['id' => 'ingrediente_id'])
            ->viaTable('ingrediente_alergeno', ['alergeno_id' => 'id']);
    }

    /**
     * Función en la que se establecen las reglas que deben cumplir las propiedades del Alérgeno.
     * @return array Array con las reglas de las propiedades del Alérgeno.
     */
    public function rules()
    {
        return [
            [['nombre'], 'required'],
            [['nombre'], 'string', 'max' => 30],
            [['nombre'], 'unique'],
        ];
    }

}
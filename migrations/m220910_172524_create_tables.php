<?php

use yii\db\Migration;

/**
 * Class m220910_172524_create_tables
 */
class m220910_172524_create_tables extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%plato}}', [
            'id' => $this->primaryKey(),
            'nombre' => $this->string(100)->notNull()
        ]);

        $this->createTable('{{%ingrediente}}', [
            'id' => $this->primaryKey(),
            'nombre' => $this->string(50)->notNull()
        ]);

        $this->createTable('{{%alergeno}}', [
            'id' => $this->primaryKey(),
            'nombre' => $this->string(50)->notNull()
        ]);

        $this->createTable('{{%plato_ingrediente}}', [
            'id' => $this->primaryKey(),
            'plato_id' => $this->integer(),
            'ingrediente_id' => $this->integer()
        ]);

        $this->addForeignKey('FK_PlatoIngrediente_Plato', '{{%plato_ingrediente}}', '{{%plato_id}}', '{{%plato}}', '{{%id}}');
        $this->addForeignKey('FK_PlatoIngrediente_Ingrediente', '{{%plato_ingrediente}}', '{{%ingrediente_id}}', '{{%ingrediente}}', '{{%id}}');

        $this->createTable('{{%ingrediente_alergeno}}', [
            'id' => $this->primaryKey(),
            'ingrediente_id' => $this->integer(),
            'alergeno_id' => $this->integer(),
        ]);

        $this->addForeignKey('FK_ngredienteAlergeno_Ingrediente', '{{%ingrediente_alergeno}}', '{{%ingrediente_id}}', '{{%ingrediente}}', '{{%id}}');
        $this->addForeignKey('FK_IngredienteAlergeno_Alergeno', '{{%ingrediente_alergeno}}', '{{%alergeno_id}}', '{{%alergeno}}', '{{%id}}');
    }



    private function insertTestData(){
        $faker = \Faker\Factory::create();
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('FK_IngredienteAlergeno_Alergeno', '{{%ingrediente_alergeno}}');
        $this->dropForeignKey('FK_ngredienteAlergeno_Ingrediente', '{{%ingrediente_alergeno}}');
        $this->dropForeignKey('FK_PlatoIngrediente_Ingrediente', '{{%plato_ingrediente}}');
        $this->dropForeignKey('FK_PlatoIngrediente_Plato', '{{%plato_ingrediente}}');

        $this->dropTable('{{%alergeno}}');
        $this->dropTable('{{%ingrediente}}');
        $this->dropTable('{{%plato}}');

    }
}

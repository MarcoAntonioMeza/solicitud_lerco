<?php

use yii\db\Migration;

/**
 * Class m250423_183408_cuestionarios  
 */
class m250423_183408_cuestionarios extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp() {}

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m250423_182556_cuestionarios cannot be reverted.\n";

        return false;
    }

    public function up()
    {
        $this->createTable('cuestionarios_grupo', [
            'id' => $this->primaryKey(),
            'nombre' => $this->string(255)->notNull(),
            'orden' => $this->integer()->defaultValue(null),
            'descripcion' => $this->text()->defaultValue(null),
            'estado' => $this->integer()->notNull()->defaultValue(1),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->defaultValue(null),
            'created_by' => $this->smallInteger(5)->unsigned()->defaultValue(null),
            'updated_by' => $this->smallInteger(5)->unsigned()->defaultValue(null),
        ]);

        $this->createTable('cuestionarios_preguntas', [
            'id' => $this->primaryKey(),
            'cuestionario_id' => $this->integer()->notNull(), // Relación a grupo
            'pregunta' => $this->string(255)->notNull(),
            'tipo_respuesta' => $this->integer()->notNull()->defaultValue(1),
            'estado' => $this->integer()->notNull()->defaultValue(1),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->defaultValue(null),
            'created_by' => $this->smallInteger(5)->unsigned()->defaultValue(null),
            'updated_by' => $this->smallInteger(5)->unsigned()->defaultValue(null),
        ]);

        $this->createTable('cuestionarios_respuestas_catalogo_select', [
            'id' => $this->primaryKey(),
            'pregunta_id' => $this->integer()->notNull(),
            'estado' => $this->integer()->notNull()->defaultValue(1),
            'valor' => $this->string(255)->notNull(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->defaultValue(null),
            'created_by' => $this->smallInteger(5)->unsigned()->defaultValue(null),
            'updated_by' => $this->smallInteger(5)->unsigned()->defaultValue(null),
        ]);

        $this->createTable('cuestionarios_respuestas', [
            'id' => $this->primaryKey(),
            'pregunta_id' => $this->integer()->notNull(),
            'solicitud_id' => $this->integer()->notNull(),
            'respuesta' => $this->text()->notNull(),
            'estado' => $this->integer()->notNull()->defaultValue(1),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->defaultValue(null),
            'created_by' => $this->smallInteger(5)->unsigned()->defaultValue(null),
            'updated_by' => $this->smallInteger(5)->unsigned()->defaultValue(null),
        ]);

        $this->createTable('cuestionarios_orden_grupo', [
            'id' => $this->primaryKey(),
            'grupo_id' => $this->integer()->notNull(),
            'orden' => $this->integer()->notNull(),
        ]);

        // === Foreign Keys ===

        // Para cuestionarios_grupo
        $this->addForeignKey(
            'fk_grupo_created_by',
            'cuestionarios_grupo',
            'created_by',
            'user',
            'id',
            'SET NULL',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk_grupo_updated_by',
            'cuestionarios_grupo',
            'updated_by',
            'user',
            'id',
            'SET NULL',
            'CASCADE'
        );

        // Para cuestionarios_preguntas
        $this->addForeignKey(
            'fk_preguntas_created_by',
            'cuestionarios_preguntas',
            'created_by',
            'user',
            'id',
            'SET NULL',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk_preguntas_updated_by',
            'cuestionarios_preguntas',
            'updated_by',
            'user',
            'id',
            'SET NULL',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk_preguntas_grupo_id',
            'cuestionarios_preguntas',
            'cuestionario_id',
            'cuestionarios_grupo',
            'id',
            'CASCADE',
            'CASCADE'
        );

        // Para cuestionarios_respuestas_catalogo_select
        $this->addForeignKey(
            'fk_catalogo_created_by',
            'cuestionarios_respuestas_catalogo_select',
            'created_by',
            'user',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk_catalogo_updated_by',
            'cuestionarios_respuestas_catalogo_select',
            'updated_by',
            'user',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk_catalogo_pregunta_id',
            'cuestionarios_respuestas_catalogo_select',
            'pregunta_id',
            'cuestionarios_preguntas',
            'id',
            'CASCADE',
            'CASCADE'
        );

        // Para cuestionarios_respuestas
        $this->addForeignKey(
            'fk_respuestas_created_by',
            'cuestionarios_respuestas',
            'created_by',
            'user',
            'id',
            'SET NULL',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk_respuestas_updated_by',
            'cuestionarios_respuestas',
            'updated_by',
            'user',
            'id',
            'SET NULL',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk_respuestas_pregunta_id',
            'cuestionarios_respuestas',
            'pregunta_id',
            'cuestionarios_preguntas',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk_respuestas_solicitud_id',
            'cuestionarios_respuestas',
            'solicitud_id',
            'solicitud',
            'id',
            'CASCADE',
            'CASCADE'
        );
    }

    public function down()
    {
        // Eliminar foreign keys en orden inverso

        // cuestionarios_respuestas
        $this->dropForeignKey('fk_respuestas_solicitud_id', 'cuestionarios_respuestas');
        $this->dropForeignKey('fk_respuestas_pregunta_id', 'cuestionarios_respuestas');
        $this->dropForeignKey('fk_respuestas_created_by', 'cuestionarios_respuestas');
        $this->dropForeignKey('fk_respuestas_updated_by', 'cuestionarios_respuestas');

        // cuestionarios_respuestas_catalogo_select
        $this->dropForeignKey('fk_catalogo_pregunta_id', 'cuestionarios_respuestas_catalogo_select');
        $this->dropForeignKey('fk_catalogo_created_by', 'cuestionarios_respuestas_catalogo_select');
        $this->dropForeignKey('fk_catalogo_updated_by', 'cuestionarios_respuestas_catalogo_select');

        // cuestionarios_preguntas
        $this->dropForeignKey('fk_preguntas_grupo_id', 'cuestionarios_preguntas');
        $this->dropForeignKey('fk_preguntas_created_by', 'cuestionarios_preguntas');
        $this->dropForeignKey('fk_preguntas_updated_by', 'cuestionarios_preguntas');

        // cuestionarios_grupo
        $this->dropForeignKey('fk_grupo_created_by', 'cuestionarios_grupo');
        $this->dropForeignKey('fk_grupo_updated_by', 'cuestionarios_grupo');

        // Eliminar tablas en orden inverso
        $this->dropTable('cuestionarios_orden_grupo');
        $this->dropTable('cuestionarios_respuestas');
        $this->dropTable('cuestionarios_respuestas_catalogo_select');
        $this->dropTable('cuestionarios_preguntas');
        $this->dropTable('cuestionarios_grupo');
    }


    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250423_182556_cuestionarios cannot be reverted.\n";

        return false;
    }
    */
}

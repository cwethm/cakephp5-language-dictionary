<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

class CreateTranslationsTable extends AbstractMigration
{
    /**
     * Change Method.
     *
     * More information on this method is available here:
     * https://book.cakephp.org/migrations/4/en/index.html#the-change-method
     *
     * @return void
     */
    public function change(): void
    {
        $table = $this->table('translations');
        $table
            ->addColumn('word_id', 'integer', [
                'default' => null,
                'null' => false,
            ])
            ->addColumn('translated_word', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => false,
            ])
            ->addColumn('language_code', 'string', [
                'default' => null,
                'limit' => 10,
                'null' => false,
            ])
            ->addColumn('created', 'datetime', [
                'default' => null,
                'null' => false,
            ])
            ->addColumn('modified', 'datetime', [
                'default' => null,
                'null' => false,
            ])
            ->addIndex(['word_id'])
            ->addIndex(['language_code'])
            ->addIndex(['word_id', 'language_code'], ['unique' => true])
            ->addForeignKey('word_id', 'words', 'id', ['delete' => 'CASCADE', 'update' => 'NO_ACTION'])
            ->create();
    }
}

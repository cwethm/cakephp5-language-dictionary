<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

class CreateWordsTable extends AbstractMigration
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
        $table = $this->table('words');
        $table
            ->addColumn('word', 'string', [
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
            ->addIndex(['language_code'])
            ->addIndex(['word', 'language_code'], ['unique' => true])
            ->create();
    }
}

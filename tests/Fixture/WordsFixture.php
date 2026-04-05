<?php
declare(strict_types=1);

namespace LanguageDictionary\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * WordsFixture
 */
class WordsFixture extends TestFixture
{
    /**
     * ORM table alias (plugin-prefixed so the ORM resolves the correct table class)
     *
     * @var string
     */
    public string $tableAlias = 'LanguageDictionary.Words';

    /**
     * Init method
     *
     * @return void
     */
    public function init(): void
    {
        $this->records = [
            [
                'id' => 1,
                'word' => 'hello',
                'language_code' => 'en',
                'created' => '2024-01-01 00:00:00',
                'modified' => '2024-01-01 00:00:00',
            ],
            [
                'id' => 2,
                'word' => 'world',
                'language_code' => 'en',
                'created' => '2024-01-01 00:00:00',
                'modified' => '2024-01-01 00:00:00',
            ],
            [
                'id' => 3,
                'word' => 'hola',
                'language_code' => 'es',
                'created' => '2024-01-01 00:00:00',
                'modified' => '2024-01-01 00:00:00',
            ],
        ];
        parent::init();
    }
}


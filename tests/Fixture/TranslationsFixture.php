<?php
declare(strict_types=1);

namespace LanguageDictionary\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * TranslationsFixture
 */
class TranslationsFixture extends TestFixture
{
    /**
     * ORM table alias (plugin-prefixed so the ORM resolves the correct table class)
     *
     * @var string
     */
    public string $tableAlias = 'LanguageDictionary.Translations';

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
                'word_id' => 1,
                'translated_word' => 'hola',
                'language_code' => 'es',
                'created' => '2024-01-01 00:00:00',
                'modified' => '2024-01-01 00:00:00',
            ],
            [
                'id' => 2,
                'word_id' => 1,
                'translated_word' => 'bonjour',
                'language_code' => 'fr',
                'created' => '2024-01-01 00:00:00',
                'modified' => '2024-01-01 00:00:00',
            ],
            [
                'id' => 3,
                'word_id' => 2,
                'translated_word' => 'monde',
                'language_code' => 'fr',
                'created' => '2024-01-01 00:00:00',
                'modified' => '2024-01-01 00:00:00',
            ],
        ];
        parent::init();
    }
}


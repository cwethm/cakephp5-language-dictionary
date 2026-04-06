<?php
declare(strict_types=1);

namespace LanguageDictionary\Test\TestCase\Model\Table;

use Cake\TestSuite\TestCase;
use LanguageDictionary\Model\Table\TranslationsTable;

/**
 * LanguageDictionary\Model\Table\TranslationsTable Test Case
 */
class TranslationsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \LanguageDictionary\Model\Table\TranslationsTable
     */
    protected TranslationsTable $Translations;

    /**
     * Fixtures
     *
     * @var list<string>
     */
    protected array $fixtures = [
        'plugin.LanguageDictionary.Words',
        'plugin.LanguageDictionary.Translations',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Translations') ? [] : ['className' => TranslationsTable::class];
        $this->Translations = $this->getTableLocator()->get('Translations', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->Translations);
        parent::tearDown();
    }

    /**
     * Test initialize method
     *
     * @return void
     */
    public function testInitialize(): void
    {
        $this->assertNotEmpty($this->Translations->getTable());
        $this->assertEquals('translations', $this->Translations->getTable());
        $this->assertEquals('translated_word', $this->Translations->getDisplayField());
        $this->assertEquals('id', $this->Translations->getPrimaryKey());
        $this->assertTrue($this->Translations->hasBehavior('Timestamp'));
        $this->assertTrue($this->Translations->hasAssociation('Words'));
    }

    /**
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault(): void
    {
        $translation = $this->Translations->newEntity([]);
        $this->assertNotEmpty($translation->getErrors());

        $validTranslation = $this->Translations->newEntity([
            'word_id' => 1,
            'translated_word' => 'hola',
            'language_code' => 'es',
        ]);
        $this->assertEmpty($validTranslation->getErrors());
    }

    /**
     * Test findByLanguage custom finder
     *
     * @return void
     */
    public function testFindByLanguage(): void
    {
        $frenchTranslations = $this->Translations->find('byLanguage', languageCode: 'fr')->all();
        $this->assertCount(2, $frenchTranslations);

        $spanishTranslations = $this->Translations->find('byLanguage', languageCode: 'es')->all();
        $this->assertCount(1, $spanishTranslations);
    }
}

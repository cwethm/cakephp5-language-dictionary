<?php
declare(strict_types=1);

namespace LanguageDictionary\Test\TestCase\Model\Table;

use Cake\TestSuite\TestCase;
use LanguageDictionary\Model\Table\WordsTable;

/**
 * LanguageDictionary\Model\Table\WordsTable Test Case
 */
class WordsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \LanguageDictionary\Model\Table\WordsTable
     */
    protected WordsTable $Words;

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
        $config = $this->getTableLocator()->exists('Words') ? [] : ['className' => WordsTable::class];
        $this->Words = $this->getTableLocator()->get('Words', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->Words);
        parent::tearDown();
    }

    /**
     * Test initialize method
     *
     * @return void
     */
    public function testInitialize(): void
    {
        $this->assertNotEmpty($this->Words->getTable());
        $this->assertEquals('words', $this->Words->getTable());
        $this->assertEquals('word', $this->Words->getDisplayField());
        $this->assertEquals('id', $this->Words->getPrimaryKey());
        $this->assertTrue($this->Words->hasBehavior('Timestamp'));
        $this->assertTrue($this->Words->hasAssociation('Translations'));
    }

    /**
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault(): void
    {
        $word = $this->Words->newEntity([]);
        $this->assertNotEmpty($word->getErrors());

        $validWord = $this->Words->newEntity([
            'word' => 'test',
            'language_code' => 'en',
        ]);
        $this->assertEmpty($validWord->getErrors());
    }

    /**
     * Test findByLanguage custom finder
     *
     * @return void
     */
    public function testFindByLanguage(): void
    {
        $words = $this->Words->find('byLanguage', languageCode: 'en')->all();
        $this->assertCount(2, $words);

        $spanishWords = $this->Words->find('byLanguage', languageCode: 'es')->all();
        $this->assertCount(1, $spanishWords);
    }

    /**
     * Test findWithTranslations custom finder
     *
     * @return void
     */
    public function testFindWithTranslations(): void
    {
        $words = $this->Words->find('withTranslations')->all();
        $this->assertNotEmpty($words);

        $firstWord = $words->first();
        $this->assertNotEmpty($firstWord->translations);
    }
}

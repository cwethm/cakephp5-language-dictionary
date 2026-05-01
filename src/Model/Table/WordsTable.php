<?php
declare(strict_types=1);

namespace LanguageDictionary\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Words Model
 *
 * @property \LanguageDictionary\Model\Table\TranslationsTable&\Cake\ORM\Association\HasMany $Translations
 *
 * @method \LanguageDictionary\Model\Entity\Word newEmptyEntity()
 * @method \LanguageDictionary\Model\Entity\Word newEntity(array $data, array $options = [])
 * @method array<\LanguageDictionary\Model\Entity\Word> newEntities(array $data, array $options = [])
 * @method \LanguageDictionary\Model\Entity\Word get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \LanguageDictionary\Model\Entity\Word findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \LanguageDictionary\Model\Entity\Word patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\LanguageDictionary\Model\Entity\Word> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \LanguageDictionary\Model\Entity\Word|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \LanguageDictionary\Model\Entity\Word saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\LanguageDictionary\Model\Entity\Word>|\Cake\Datasource\ResultSetInterface<\LanguageDictionary\Model\Entity\Word>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\LanguageDictionary\Model\Entity\Word>|\Cake\Datasource\ResultSetInterface<\LanguageDictionary\Model\Entity\Word> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\LanguageDictionary\Model\Entity\Word>|\Cake\Datasource\ResultSetInterface<\LanguageDictionary\Model\Entity\Word>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\LanguageDictionary\Model\Entity\Word>|\Cake\Datasource\ResultSetInterface<\LanguageDictionary\Model\Entity\Word> deleteManyOrFail(iterable $entities, array $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class WordsTable extends Table
{
    /**
     * Initialize method
     *
     * @param array<string, mixed> $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('words');
        $this->setDisplayField('word');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->hasMany('Translations', [
            'foreignKey' => 'word_id',
            'className' => 'LanguageDictionary.Translations',
            'dependent' => true,
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->scalar('word')
            ->maxLength('word', 255)
            ->requirePresence('word', 'create')
            ->notEmptyString('word');

        $validator
            ->scalar('language_code')
            ->maxLength('language_code', 10)
            ->requirePresence('language_code', 'create')
            ->notEmptyString('language_code');

        return $validator;
    }

    /**
     * Find words by language.
     *
     * @param \Cake\ORM\Query\SelectQuery $query The query to modify.
     * @param string $languageCode The language code to filter by.
     * @return \Cake\ORM\Query\SelectQuery
     */
    public function findByLanguage(SelectQuery $query, string $languageCode): SelectQuery
    {
        return $query->where(['Words.language_code' => $languageCode]);
    }

    /**
     * Find a word and its translations.
     *
     * @param \Cake\ORM\Query\SelectQuery $query The query to modify.
     * @return \Cake\ORM\Query\SelectQuery
     */
    public function findWithTranslations(SelectQuery $query): SelectQuery
    {
        return $query->contain(['Translations']);
    }
}

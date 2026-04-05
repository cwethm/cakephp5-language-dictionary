<?php
declare(strict_types=1);

namespace LanguageDictionary\Model\Table;

use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Translations Model
 *
 * @property \LanguageDictionary\Model\Table\WordsTable&\Cake\ORM\Association\BelongsTo $Words
 *
 * @method \LanguageDictionary\Model\Entity\Translation newEmptyEntity()
 * @method \LanguageDictionary\Model\Entity\Translation newEntity(array $data, array $options = [])
 * @method array<\LanguageDictionary\Model\Entity\Translation> newEntities(array $data, array $options = [])
 * @method \LanguageDictionary\Model\Entity\Translation get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \LanguageDictionary\Model\Entity\Translation findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \LanguageDictionary\Model\Entity\Translation patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\LanguageDictionary\Model\Entity\Translation> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \LanguageDictionary\Model\Entity\Translation|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \LanguageDictionary\Model\Entity\Translation saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\LanguageDictionary\Model\Entity\Translation>|\Cake\Datasource\ResultSetInterface<\LanguageDictionary\Model\Entity\Translation>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\LanguageDictionary\Model\Entity\Translation>|\Cake\Datasource\ResultSetInterface<\LanguageDictionary\Model\Entity\Translation> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\LanguageDictionary\Model\Entity\Translation>|\Cake\Datasource\ResultSetInterface<\LanguageDictionary\Model\Entity\Translation>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\LanguageDictionary\Model\Entity\Translation>|\Cake\Datasource\ResultSetInterface<\LanguageDictionary\Model\Entity\Translation> deleteManyOrFail(iterable $entities, array $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class TranslationsTable extends Table
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

        $this->setTable('translations');
        $this->setDisplayField('translated_word');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Words', [
            'foreignKey' => 'word_id',
            'joinType' => 'INNER',
            'className' => 'LanguageDictionary.Words',
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
            ->integer('word_id')
            ->notEmptyString('word_id');

        $validator
            ->scalar('translated_word')
            ->maxLength('translated_word', 255)
            ->requirePresence('translated_word', 'create')
            ->notEmptyString('translated_word');

        $validator
            ->scalar('language_code')
            ->maxLength('language_code', 10)
            ->requirePresence('language_code', 'create')
            ->notEmptyString('language_code');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules): RulesChecker
    {
        $rules->add($rules->existsIn(['word_id'], 'Words'), ['errorField' => 'word_id']);

        return $rules;
    }

    /**
     * Find translations by language code.
     *
     * @param \Cake\ORM\Query\SelectQuery $query The query to modify.
     * @param string $languageCode The language code to filter by.
     * @return \Cake\ORM\Query\SelectQuery
     */
    public function findByLanguage(\Cake\ORM\Query\SelectQuery $query, string $languageCode): \Cake\ORM\Query\SelectQuery
    {
        return $query->where(['Translations.language_code' => $languageCode]);
    }
}

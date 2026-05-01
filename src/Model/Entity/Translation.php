<?php
declare(strict_types=1);

namespace LanguageDictionary\Model\Entity;

use Cake\ORM\Entity;

/**
 * Translation Entity
 *
 * @property int $id
 * @property int $word_id
 * @property string $translated_word
 * @property string $language_code
 * @property \Cake\I18n\DateTime $created
 * @property \Cake\I18n\DateTime $modified
 *
 * @property \LanguageDictionary\Model\Entity\Word $word
 */
class Translation extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * @var array<string, bool>
     */
    protected array $_accessible = [
        'word_id' => true,
        'translated_word' => true,
        'language_code' => true,
        'created' => true,
        'modified' => true,
        'word' => true,
    ];
}

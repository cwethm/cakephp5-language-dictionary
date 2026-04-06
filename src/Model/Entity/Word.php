<?php
declare(strict_types=1);

namespace LanguageDictionary\Model\Entity;

use Cake\ORM\Entity;

/**
 * Word Entity
 *
 * @property int $id
 * @property string $word
 * @property string $language_code
 * @property \Cake\I18n\DateTime $created
 * @property \Cake\I18n\DateTime $modified
 *
 * @property \LanguageDictionary\Model\Entity\Translation[] $translations
 */
class Word extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array<string, bool>
     */
    protected array $_accessible = [
        'word' => true,
        'language_code' => true,
        'created' => true,
        'modified' => true,
        'translations' => true,
    ];
}

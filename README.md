# cakephp5-language-dictionary

A CakePHP 5 plugin providing a language dictionary with multi-language word and translation management.

## Features

- Store words in multiple languages
- Manage translations between languages
- Filter words and translations by language code
- RESTful API-ready controllers
- Database migrations included

## Requirements

- PHP >= 8.1
- CakePHP >= 5.0

## Installation

Install via Composer:

```bash
composer require cwethm/cakephp5-language-dictionary
```

Load the plugin in your application's `Application.php`:

```php
$this->addPlugin('LanguageDictionary');
```

## Database Setup

Run the plugin migrations:

```bash
bin/cake migrations migrate --plugin LanguageDictionary
```

This creates two tables:
- **words** – stores source words with their language code
- **translations** – stores translated words linked to their source word

## Usage

### Routes

The plugin registers routes under `/language-dictionary`:

| Method | URL                                 | Action                  |
|--------|-------------------------------------|-------------------------|
| GET    | /language-dictionary/words          | List all words          |
| GET    | /language-dictionary/words/1        | View a word             |
| POST   | /language-dictionary/words          | Create a word           |
| PUT    | /language-dictionary/words/1        | Update a word           |
| DELETE | /language-dictionary/words/1        | Delete a word           |
| GET    | /language-dictionary/translations   | List all translations   |
| GET    | /language-dictionary/translations/1 | View a translation      |
| POST   | /language-dictionary/translations   | Create a translation    |
| PUT    | /language-dictionary/translations/1 | Update a translation    |
| DELETE | /language-dictionary/translations/1 | Delete a translation    |

### Filtering by Language

Append `?language=en` to the words index route to filter by language code:

```
GET /language-dictionary/words?language=en
```

### Model Usage

```php
// Load the Words table
$words = $this->fetchTable('LanguageDictionary.Words');

// Find all English words with their translations
$englishWords = $words->find('byLanguage', languageCode: 'en')
    ->find('withTranslations')
    ->all();

// Load the Translations table
$translations = $this->fetchTable('LanguageDictionary.Translations');

// Find all French translations
$frenchTranslations = $translations->find('byLanguage', languageCode: 'fr')->all();
```

## Running Tests

```bash
composer install
vendor/bin/phpunit
```

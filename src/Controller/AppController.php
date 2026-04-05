<?php
declare(strict_types=1);

namespace LanguageDictionary\Controller;

use Cake\Controller\Controller;

/**
 * Application controller for the LanguageDictionary plugin.
 */
class AppController extends Controller
{
    /**
     * Initialization hook method.
     *
     * @return void
     */
    public function initialize(): void
    {
        parent::initialize();

        $this->loadComponent('RequestHandler');
        $this->loadComponent('Flash');
    }
}

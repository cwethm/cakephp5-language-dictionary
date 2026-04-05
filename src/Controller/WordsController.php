<?php
declare(strict_types=1);

namespace LanguageDictionary\Controller;

use Cake\Http\Exception\NotFoundException;

/**
 * Words Controller
 *
 * @property \LanguageDictionary\Model\Table\WordsTable $Words
 */
class WordsController extends AppController
{
    /**
     * Index method - list all words, optionally filtered by language.
     *
     * @return \Cake\Http\Response|null|void
     */
    public function index()
    {
        $languageCode = $this->request->getQuery('language');

        $query = $this->Words->find();
        if ($languageCode !== null) {
            $query = $this->Words->find('byLanguage', languageCode: $languageCode);
        }

        $words = $this->paginate($query);
        $this->set(compact('words'));
        $this->viewBuilder()->setOption('serialize', ['words']);
    }

    /**
     * View method - show a single word with its translations.
     *
     * @param string|null $id Word id.
     * @return \Cake\Http\Response|null|void
     * @throws \Cake\Http\Exception\NotFoundException When record not found.
     */
    public function view(?string $id = null)
    {
        $word = $this->Words->get((int)$id, contain: ['Translations']);
        $this->set(compact('word'));
        $this->viewBuilder()->setOption('serialize', ['word']);
    }

    /**
     * Add method - create a new word.
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $word = $this->Words->newEmptyEntity();
        if ($this->request->is('post')) {
            $word = $this->Words->patchEntity($word, $this->request->getData());
            if ($this->Words->save($word)) {
                $this->Flash->success(__('The word has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The word could not be saved. Please, try again.'));
        }
        $this->set(compact('word'));
        $this->viewBuilder()->setOption('serialize', ['word']);
    }

    /**
     * Edit method - update an existing word.
     *
     * @param string|null $id Word id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Http\Exception\NotFoundException When record not found.
     */
    public function edit(?string $id = null)
    {
        $word = $this->Words->get((int)$id);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $word = $this->Words->patchEntity($word, $this->request->getData());
            if ($this->Words->save($word)) {
                $this->Flash->success(__('The word has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The word could not be saved. Please, try again.'));
        }
        $this->set(compact('word'));
        $this->viewBuilder()->setOption('serialize', ['word']);
    }

    /**
     * Delete method - remove a word and its translations.
     *
     * @param string|null $id Word id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Http\Exception\NotFoundException When record not found.
     */
    public function delete(?string $id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $word = $this->Words->get((int)$id);
        if ($this->Words->delete($word)) {
            $this->Flash->success(__('The word has been deleted.'));
        } else {
            $this->Flash->error(__('The word could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}

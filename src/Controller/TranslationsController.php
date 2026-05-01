<?php
declare(strict_types=1);

namespace LanguageDictionary\Controller;

/**
 * Translations Controller
 *
 * @property \LanguageDictionary\Model\Table\TranslationsTable $Translations
 */
class TranslationsController extends AppController
{
    /**
     * Index method - list all translations for a word.
     *
     * @param string|null $wordId Word id.
     * @return \Cake\Http\Response|null|void
     */
    public function index(?string $wordId = null)
    {
        $query = $this->Translations->find()->contain(['Words']);
        if ($wordId !== null) {
            $query = $query->where(['Translations.word_id' => (int)$wordId]);
        }

        $translations = $this->paginate($query);
        $this->set(compact('translations'));
        $this->viewBuilder()->setOption('serialize', ['translations']);
    }

    /**
     * View method - show a single translation.
     *
     * @param string|null $id Translation id.
     * @return \Cake\Http\Response|null|void
     * @throws \Cake\Http\Exception\NotFoundException When record not found.
     */
    public function view(?string $id = null)
    {
        $translation = $this->Translations->get((int)$id, contain: ['Words']);
        $this->set(compact('translation'));
        $this->viewBuilder()->setOption('serialize', ['translation']);
    }

    /**
     * Add method - create a new translation for a word.
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $translation = $this->Translations->newEmptyEntity();
        if ($this->request->is('post')) {
            $translation = $this->Translations->patchEntity($translation, $this->request->getData());
            if ($this->Translations->save($translation)) {
                $this->Flash->success(__('The translation has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The translation could not be saved. Please, try again.'));
        }
        $words = $this->Translations->Words->find('list', limit: 200)->all();
        $this->set(compact('translation', 'words'));
        $this->viewBuilder()->setOption('serialize', ['translation']);
    }

    /**
     * Edit method - update an existing translation.
     *
     * @param string|null $id Translation id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Http\Exception\NotFoundException When record not found.
     */
    public function edit(?string $id = null)
    {
        $translation = $this->Translations->get((int)$id);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $translation = $this->Translations->patchEntity($translation, $this->request->getData());
            if ($this->Translations->save($translation)) {
                $this->Flash->success(__('The translation has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The translation could not be saved. Please, try again.'));
        }
        $words = $this->Translations->Words->find('list', limit: 200)->all();
        $this->set(compact('translation', 'words'));
        $this->viewBuilder()->setOption('serialize', ['translation']);
    }

    /**
     * Delete method - remove a translation.
     *
     * @param string|null $id Translation id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Http\Exception\NotFoundException When record not found.
     */
    public function delete(?string $id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $translation = $this->Translations->get((int)$id);
        if ($this->Translations->delete($translation)) {
            $this->Flash->success(__('The translation has been deleted.'));
        } else {
            $this->Flash->error(__('The translation could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}

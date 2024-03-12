<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Http\Exception\NotFoundException;

class UsersController extends AppController
{
    // Retrieve All Users
    public function index()
    {
        $Users = $this->Users->find('all')->toArray();
        $this->set([
            'Users' => $Users,
            '_serialize' => ['Users']
        ]);
    }

    // Retrieve a Single Article
    public function view($id)
    {
        $article = $this->Users->get($id);
        $this->set([
            'article' => $article,
            '_serialize' => ['article']
        ]);
    }

    // Create an Article
    public function add()
    {
        $article = $this->Users->newEmptyEntity();
        if ($this->request->is('post')) {
            $article = $this->Users->patchEntity($article, $this->request->getData());
            if ($this->Users->save($article)) {
                $this->set([
                    'article' => $article,
                    '_serialize' => ['article'],
                    '_status' => 201
                ]);
                return;
            }
        }
        $this->set([
            'error' => $article->getErrors(),
            '_serialize' => ['error']
        ]);
    }

    // Update an Article
    public function edit($id)
    {
        $article = $this->Users->get($id);
        if ($this->request->is(['patch', 'put'])) {
            $article = $this->Users->patchEntity($article, $this->request->getData());
            if ($this->Users->save($article)) {
                $this->set([
                    'article' => $article,
                    '_serialize' => ['article']
                ]);
                return;
            }
        }
        $this->set([
            'error' => $article->getErrors(),
            '_serialize' => ['error']
        ]);
    }

    // Delete an Article
    public function delete($id)
    {
        $article = $this->Users->get($id);
        if ($this->Users->delete($article)) {
            $this->set([
                'message' => 'Article deleted successfully',
                '_serialize' => ['message']
            ]);
            return;
        }
        $this->set([
            'error' => 'Failed to delete the article',
            '_serialize' => ['error']
        ]);
    }
}

<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\Locator\LocatorAwareTrait;

class ArticlesController extends AppController
{
    public function initialize(): void
    {
        parent::initialize();
        $this->loadComponent('RequestHandler');
        $this->loadComponent('App.JWT');
    }

    // Retrieve All Articles
    public function index()
    {
        $articles = $this->Articles->find('all')->toArray();
        $this->set([
            'articles' => $articles,
            '_serialize' => ['articles']
        ]);
    }

    // Retrieve a Single Article
    public function view($id)
    {
        $article = $this->Articles->get($id);

        $likes = $this->getTableLocator()->get('Likes');
        $query = $likes->find('all', ['conditions' => ['Likes.article_id =' => $id]]);
        $number = $query->count();

        $this->set([
            'data' => ['article' => $article, 'number_of_likes' => $number],
            '_serialize' => ['data']
        ]);
    }

    // Create an Article
    public function add()
    {
        // Check login token
        $token = explode(" ", $this->request->getHeader('Authorization')[0]);
        $this->JWT->decodeToken($token[1]);

        $article = $this->Articles->newEmptyEntity();
        if ($this->request->is('post')) {
            $article = $this->Articles->patchEntity($article, $this->request->getData());
            if ($this->Articles->save($article)) {
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
        // Check login token
        $token = explode(" ", $this->request->getHeader('Authorization')[0]);
        $this->JWT->decodeToken($token[1]);

        $article = $this->Articles->get($id);
        if ($this->request->is(['patch', 'put'])) {
            $article = $this->Articles->patchEntity($article, $this->request->getData());
            if ($this->Articles->save($article)) {
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
        // Check login token
        $token = explode(" ", $this->request->getHeader('Authorization')[0]);
        $this->JWT->decodeToken($token[1]);

        $article = $this->Articles->get($id);
        if ($this->Articles->delete($article)) {
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

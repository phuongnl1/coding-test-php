<?php
namespace App\Controller;

use App\Controller\AppController;

class LikesController extends AppController
{
    public function initialize(): void
    {
        parent::initialize();
        $this->loadComponent('RequestHandler');
        $this->loadComponent('App.JWT');
    }

    // Retrieve All Likes
    public function index()
    {
        $likes = $this->Likes->find('all')->toArray();
        $this->set([
            'likes' => $likes,
            '_serialize' => ['likes']
        ]);
    }

    // Create an Like
    public function add()
    {
        $errorMsg = [];
        // Check login token
        $token = explode(" ", $this->request->getHeader('Authorization')[0]);
        $this->JWT->decodeToken($token[1]);

        $like = $this->Likes->newEmptyEntity();
        if ($this->request->is('post')) {
            $params = $this->request->getData();
            if ((isset($params['user_id']) && $params['user_id'] != 0) && (isset($params['article_id']) && $params['article_id'] != 0)) {
                $query = $this->Likes->find('all', [
                    'conditions' => ['Likes.user_id =' => $params['user_id'], 'Likes.article_id =' => $params['article_id']]
                ]);
                $number = $query->count();
                if (!$number) {
                    $like = $this->Likes->patchEntity($like, $this->request->getData());
                    if ($this->Likes->save($like)) {
                        $this->set([
                            'like' => $like,
                            '_serialize' => ['like'],
                            '_status' => 201
                        ]);
                        return;
                    }
                } else {
                    $errorMsg[] = 'This user has liked this article';
                }

            } else {
                $errorMsg[] = 'Data is invalid';
            }

        }
        $this->set([
            'error' => $like->getErrors() ? $like->getErrors() : $errorMsg,
            '_serialize' => ['error']
        ]);
    }
}

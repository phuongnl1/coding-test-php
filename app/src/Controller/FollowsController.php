<?php
namespace App\Controller;

use App\Controller\AppController;

class FollowsController extends AppController
{
    public function initialize(): void
    {
        parent::initialize();
        $this->loadComponent('RequestHandler');
        $this->loadComponent('App.JWT');
    }

    // Retrieve My Following
    public function index()
    {
        // Check login token
        $token = explode(" ", $this->request->getHeader('Authorization')[0]);
        $user = $this->JWT->decodeToken($token[1]);

        if (isset($user['id']) && $user['id']) {
            $following = $this->Follows->find('all', [
                'conditions' => ['Follows.follower_user_id =' => $user['id']]
            ])->toArray();

            $this->set([
                'following' => $following,
                '_serialize' => ['following']
            ]);
        } else {
            $this->set([
                'following' => [],
                '_serialize' => ['following']
            ]);
        }

        /*
        $follows = $this->Follows->find('all')->toArray();
        $this->set([
            'follows' => $follows,
            '_serialize' => ['follows']
        ]);
        */
    }

    // Create an Follow
    public function add()
    {
        $errorMsg = [];
        // Check login token
        $token = explode(" ", $this->request->getHeader('Authorization')[0]);
        $user = $this->JWT->decodeToken($token[1]);

        $follow = $this->Follows->newEmptyEntity();
        if ($this->request->is('post')) {
            $params = $this->request->getData();
            if ((isset($params['followed_user_id']) && $params['followed_user_id'] != 0) && isset($user['id'])) {
                $query = $this->Follows->find('all', [
                    'conditions' => ['Follows.follower_user_id =' => $user['id'], 'Follows.followed_user_id =' => $params['followed_user_id']]
                ]);
                $number = $query->count();
                if (!$number) {
                    $tmpData = $this->request->getData();
                    $tmpData['follower_user_id'] = $user['id'];
                    $follow = $this->Follows->patchEntity($follow, $tmpData);
                    if ($this->Follows->save($follow)) {
                        $this->set([
                            'follow' => $follow,
                            '_serialize' => ['follow'],
                            '_status' => 201
                        ]);
                        return;
                    }
                } else {
                    $errorMsg[] = 'This user has followed this user';
                }

            } else {
                $errorMsg[] = 'Data is invalid';
            }

        }
        $this->set([
            'error' => $follow->getErrors() ? $follow->getErrors() : $errorMsg,
            '_serialize' => ['error']
        ]);
    }

    // My Following
    public function myFollowing()
    {
        // Check login token
        $token = explode(" ", $this->request->getHeader('Authorization')[0]);
        $user = $this->JWT->decodeToken($token[1]);

        if (isset($user['id']) && $user['id']) {
            $myFollowing = $query = $this->Follows->find('all', [
                'conditions' => ['Follows.follower_user_id =' => $user['id']]
            ])->toArray();

            $this->set([
                'follows' => $myFollowing,
                '_serialize' => ['myFollowing']
            ]);
        } else {
            $this->set([
                'follows' => [],
                '_serialize' => ['myFollowing']
            ]);
        }
    }
}

<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Http\Exception\UnauthorizedException;

class UsersController extends AppController
{
    public function initialize(): void
    {
        parent::initialize();
        $this->loadComponent('RequestHandler');
        $this->loadComponent('App.JWT');
    }

    // Login Pape
    public function userLogin() {
    }

    //Logout Pape
    public function userLogout() {
    }

    // API Login
    public function login()
    {
        // Authenticate user
        $user = $this->Users->find()->where([
            'email' => $this->request->getData('email'),
            'password' => md5($this->request->getData('password'))
        ])->first();

        if (!$user) {
            throw new UnauthorizedException('Invalid email or password');
        }

        $token = $this->JWT->generateToken(['id' => $user->id, 'email' => $user->email]);

        $this->set([
            'data' => ['user' => ['email' => $user->email, 'user_id' => $user->id], 'token' => $token],
            '_serialize' => ['data']
        ]);
    }

    // API Retrieve All Users
    public function index()
    {
        $Users = $this->Users->find('all')->toArray();
        $this->set([
            'Users' => $Users,
            '_serialize' => ['Users']
        ]);
    }

    // API Retrieve a Single User
    public function view($id)
    {
        $user = $this->Users->get($id);
        $this->set([
            'user' => $user,
            '_serialize' => ['user']
        ]);
    }

    // API Create an User
    public function add()
    {
        $user = $this->Users->newEmptyEntity();
        if ($this->request->is('post')) {
            $tempArray = $this->request->getData();
            $tempArray['password'] = md5($tempArray['password']);
            $user = $this->Users->patchEntity($user, $tempArray);
            if ($this->Users->save($user)) {
                $this->set([
                    'user' => $user,
                    '_serialize' => ['user'],
                    '_status' => 201
                ]);
                return;
            }
        }
        $this->set([
            'error' => $user->getErrors(),
            '_serialize' => ['error']
        ]);
    }

    // API Update an User
    public function edit($id)
    {
        $user = $this->Users->get($id);
        if ($this->request->is(['patch', 'put'])) {
            $tempArray = $this->request->getData();
            $tempArray['password'] = md5($tempArray['password']);
            $user = $this->Users->patchEntity($user, $tempArray);
            if ($this->Users->save($user)) {
                $this->set([
                    'user' => $user,
                    '_serialize' => ['user']
                ]);
                return;
            }
        }
        $this->set([
            'error' => $user->getErrors(),
            '_serialize' => ['error']
        ]);
    }

    // API Delete an User
    public function delete($id)
    {
        $user = $this->Users->get($id);
        if ($this->Users->delete($user)) {
            $this->set([
                'message' => 'User deleted successfully',
                '_serialize' => ['message']
            ]);
            return;
        }
        $this->set([
            'error' => 'Failed to delete the user',
            '_serialize' => ['error']
        ]);
    }
}

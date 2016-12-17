<?php
/**
 * Created by PhpStorm.
 * User: masterx2
 * Date: 17.12.16
 * Time: 1:37
 */

namespace Taskalka\Controllers;

use Taskalka\ControllerAbstract;
use Taskalka\Exceptions\PageError;
use Taskalka\Exceptions\RedirectNow;
use Taskalka\Models\User;

class Account extends ControllerAbstract {
    public function registerAction() {

        // #TODO Нужно проверить если кука уже есть то слать нахер

        if ($this->user) throw new RedirectNow('/');

        $login = $this->request->request->get('login', false);
        $password = $this->request->request->get('password', false);
        $email = $this->request->request->get('email', false);

        $sid = $this->request->cookies->getAlnum('tsk-user');

        if ($login === false && $password == false) return null;

        if ($login === "") throw new PageError('Empty login');
        if ($password === "") throw new PageError('Empty password');
        if ($email === "") throw new PageError('Empty email');

        if ($this->getCollection('users')->count(['login' => $login]) > 0) {
            throw new PageError('Login already exists, try login');
        }

        $user = User::new($login, $email, $password);
        $this->setCookie('tsk-user', $user->getSessionId(), 600);
        $user->save($this->getCollection('users'));

        $this->redirect('/');
    }

    public function loginAction() {

        if ($this->user) throw new RedirectNow('/');

        $login = $this->request->request->get('login', false);
        $password = $this->request->request->get('password', false);

        if ($login === false && $password == false) return null;

        if ($login === "") throw new PageError('Empty login');
        if ($password === "") throw new PageError('Empty password');

        $user = User::fromCollection(['login' => $login], $this->getCollection('users'));

        if (!$user) throw new PageError('User not found');
        if ($user->password !== sha1($password)) throw new PageError('Wrong password!');

        $this->setCookie('tsk-user', $user->getSessionId(), 600);

        $this->redirect('/');
    }

    public function logoutAction() {
        $this->setCookie('tsk-user', '', 0);
        $this->redirect('/');
    }

    public function settingsAction() {

    }

    public function invitesAction() {

    }
}
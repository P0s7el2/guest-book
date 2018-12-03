<?php

namespace app\controllers;

use app\core\Controller;

Class AccountController extends Controller{

    public function __construct($route)
    {
        parent::__construct($route);
        $this->view->layout = 'user';
    }

    public function loginAction() {
        if(!empty($_POST)){
            if(!$this->model->checkData($_POST['login'], $_POST['password'])){
                $this->view->message('error', 'login or pass is wrong');
            }
            $this->model->login($_POST['login']);
            if($_SESSION['account']['role'] == 1){
                $this->view->location('/admin');
            }
            $this->view->location('/account/posts');

        }
        $this->view->render('login');
    }

    public function registerAction() {
        if(!empty($_POST)){
            if(!$this->model->validate($_POST)){
                $this->view->message('error', $this->model->error);
            } elseif (!$this->model->checkemailExists($_POST['email'])){
                $this->view->message('error', $this->model->error);
            } elseif (!$this->model->checkloginExists($_POST['login'])){
                $this->view->message('error', $this->model->error);
            }
            $this->model->register($_POST);
            $this->view->location('/account/login');
        }
        $this->view->render('Register');
    }


    public function addAction() {
        if(!empty($_POST)){
            if(!$this->model->postValidate($_POST, 'add')) {

                $this->view->message('error', $this->model->error);
            }
            $id = $this->model->postAdd($_POST, $_SESSION['account']['id']);
            if(!$id) {
                $this->view->message('error', 'id fail');
            }
            $this->model->postUploadImage($_FILES['img']['tmp_name'], $id);
            $this->view->message('ok', 'added');
        }
        $this->view->render('Add post');
    }

    public function editAction() {
        $id = $this->route['id'];
        $check = $this->model->isPostExist($id);
        if(!$check or $check != $_SESSION['account']['id']){
            $this->view->errorCode(404);
        }
        if(!empty($_POST)){
            if(!$this->model->postValidate($_POST, 'edit')) {
                $this->view->message('error', $this->model->error);
            }
            $this->model->postEdit($_POST, $id, $_SESSION['account']['id']);

            if($_FILES['img']['tmp_name']){
                $this->model->postUploadImage($_FILES['img']['tmp_name'], $id);
            }
            $this->view->message('success', 'ok');
        }

        $vars = [
            'data' => $this->model->postData($id)[0],
        ];
        $this->view->render('Edit post', $vars);
    }

    public function deleteAction() {
        $id = $this->route['id'];
        if(!$this->model->isPostExist($id)){
            $this->view->errorCode(404);
        }
        $this->model->postDelete($id);
        $this->view->redirect('/account/posts');
    }

    public function logoutAction() {
        if($_SESSION['account']['role'] == 1){
            unset($_SESSION['admin']);
        }
        unset($_SESSION['account']);
        $this->view->redirect('/account/login');
    }

    public function postsAction() {
        $result = $this->model->getPosts($_SESSION['account']['id']);
        $vars = [
            'posts' => $result
        ];
        $this->view->render('posts', $vars);
    }
}

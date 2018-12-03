<?php

namespace app\controllers;

use app\core\Controller;
use app\lib\XlsWriter;


Class AdminController extends Controller{

    public function __construct($route)
    {
        parent::__construct($route);
        $this->view->layout = 'admin';
    }

    public function indexAction(){

        $this->view->render('export');
    }

    public function exportAction(){
        $data = $this->model->getPosts();
        $title = 'doc';
        $doc = new XlsWriter();
        $titles = array_keys($data[0]);
        $doc->writeTitles($titles, 'A', 1);
        $doc->writeArrVal($data, 'A', 2);
        $doc->save($title);
        $this->view->location('/doc.xlsx');
    }

    public function logoutAction() {
        unset($_SESSION['admin']);
        $this->view->redirect('/account/login');
    }


}


<?php

namespace app\models;

use app\core\Model;
use app\traits\TPosts;

class AccountModel extends Model {

    public $error;

    use TPosts;

    public function validate($post){

        if(!preg_match('/^[a-z0-9]{2,10}$/i', $post['login'])){
            $this->error .= 'login error ';
        }
        if(!filter_var($post['email'], FILTER_VALIDATE_EMAIL)){
            $this->error .= 'error email ';
        }
        if(!preg_match('/^[a-z0-9]{3,10}$/i', $post['password'])){
            $this->error .= 'pass error ';
        }
        if(isset($this->error)) {
            return false;
        }
        return true;
    }

    public function checkemailExists($email){
        $params = [
            'email' => $email,
        ];
        if ($this->db->column('SELECT id FROM accounts WHERE email = :email', $params)){
            $this->error = 'email already used ';
            return false;
        }
        return true;
    }

    public function checkloginExists($login){
        $params = [
            'login' => $login,
        ];
        if ($this->db->column('SELECT id FROM accounts WHERE login = :login', $params)) {
            $this->error = 'login already used ';
            return false;
        }
        return true;
    }

    public function register($post){
        $params = [
            'id' => null,
            'email' => $post['email'],
            'login' => $post['login'],
            'password' => password_hash($post['password'], PASSWORD_BCRYPT),
            'role' => 0,
        ];

        $this->db->query('INSERT INTO accounts VALUES (:id, :email, :login, :password, :role)', $params);
    }

    public function checkData($login, $password){
        $params = [
            'login' => $login,
        ];
        $hash = $this->db->column('SELECT password FROM accounts WHERE login = :login', $params);
        if (!hash or !password_verify($password, $hash)) {

            return false;
        }
        return true;
    }

    public function login($login) {
        $params = [
            'login' => $login,
        ];
        $data = $this->db->row('SELECT id, login, role FROM accounts WHERE login = :login', $params);
        $_SESSION['account'] = $data[0];
        if($data[0]['role'] == 1){
            $_SESSION['admin'] = true;
        }
    }

    public function postValidate($post, $action){
        $textLen = strlen($post['text']);
        if($textLen < 3 or $textLen > 250){
            $this->error .= 'text error 3-250 ';
        }

        if($post['mark'] > 5 or $post['mark'] < 1){
            $this->error .= 'mark error ';
        }

        if(empty($_FILES['img']['tmp_name']) and $action == 'add'){
            $this->error .= 'img error ';
        }

        if(isset($this->error))
            return false;
        return true;
    }

    public function postAdd($post, $account){
        $params = [
            'id' => null,
            'account' => $account,
            'mark' => $post['mark'],
            'text' => $post['text'],
        ];
        $this->db->query('INSERT INTO posts VALUES (:id, :account, :mark, :text, NOW())', $params);

        return $this->db->lastInsertId();
    }

    public function postUploadImage($path, $id){
        move_uploaded_file($path, 'public/materials/'.$id.'.jpg');
    }

    public function isPostExist($id) {
        $params = [
            'id' => $id,
        ];
        return $this->db->column('SELECT account FROM posts WHERE id = :id', $params);
    }

    public function postDelete($id){
        $params = [
            'id' => $id,
        ];
        $this->db->query('DELETE FROM posts WHERE id = :id', $params);
        unlink('public/materials/'.$id.'.jpg');
    }

    public function postData($id){
        $params = [
            'id' => $id,
        ];
        return $this->db->row('SELECT id, text, mark FROM posts WHERE id = :id', $params);
    }

    public function postEdit($post, $id, $account){
        $params = [
            'id' => $id,
            'account' => $account,
            'mark' => $post['mark'],
            'text' => $post['text'],
        ];

        $this->db->query('UPDATE posts SET account = :account, mark = :mark, text = :text, date = NOW() WHERE id = :id', $params);

        return $this->db->lastInsertId();
    }
 /*
    public function getPosts($account = false){
        $sql = 'SELECT posts.id, accounts.login, mark, text, date FROM posts INNER JOIN accounts ON (posts.account = accounts.id)';
        if($account){
            $params = [
                'id' => $account,
            ];
            $sql .= ' WHERE accounts.id = :id';
            $result = $this->db->row($sql, $params);
        } else {
            $result = $this->db->row('SELECT posts.id, accounts.login, mark, text, date FROM posts INNER JOIN accounts ON (posts.account = accounts.id)');
        }
        return $result;
    }*/
}

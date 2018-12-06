<?php

namespace app\traits;

trait TPosts{

    public function getPosts($account = false){
        $sql = 'SELECT posts.id, accounts.login, mark, text, date FROM posts INNER JOIN accounts ON (posts.account = accounts.id)';
        if($account){
            $params = [
                'id' => $account,
            ];
            $sql .= ' WHERE accounts.id = :id';
            $result = $this->db->row($sql, $params);
        } else {
            $result = $this->db->row($sql);
        }
        return $result;
    }

}
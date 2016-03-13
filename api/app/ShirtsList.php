<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ShirtsList extends Model {

    public function getShirts() {
        $query = "SELECT id,x,y,width,height FROM tshirts ORDER BY id DESC";
        $pdo = \DB::getPdo();
        $rows = $pdo->query($query);
        $results = [];
        foreach ($rows as $row) {
            $results[] = $row;
        }
        return \Response::make(json_encode($results), 200);
    }

}

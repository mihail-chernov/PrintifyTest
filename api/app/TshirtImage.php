<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TshirtImage extends Model {

    private $id;
    private $userImageData;
    private $x;
    private $y;
    private $width;
    private $height;
    private $thumb;

    public function addImage($x, $y, $width, $height, $imageBase64) {
        $this->x = intval($x);
        $this->y = intval($y);
        $this->width = intval($width);
        $this->height = intval($height);
        $this->userImageData = $this->decodeImageFromBase64($imageBase64);
        $this->generateThumb();
        $this->insertDB();
        return \Response::make(json_encode(array("success" => 1, "id" => $this->id)));
    }

    public function showThumb($id) {
        if (!$this->loadDB($id)) {
            Debugger::message(new \Exception("No such product!"));
        }
        try {
            $image = \imagecreatefromstring($this->thumb);
            ob_start();
            imagepng($image);
            $imageData = ob_get_contents();
            ob_end_clean();
        } catch (Exception $e) {
            Debugger::message($e);
        }
        return \Response::make($imageData, 200)->header('Content-Type', 'image/png');
    }
    
    public function loadImage($id) {
        if (!$this->loadDB($id)) {
            Debugger::message(new \Exception("No such product!"));
        }
        try {
            $image = \imagecreatefromstring($this->userImageData);
            ob_start();
            imagepng($image);
            $imageData = ob_get_contents();
            ob_end_clean();
        } catch (Exception $e) {
            Debugger::message($e);
        }
        return \Response::make($imageData, 200)->header('Content-Type', 'image/png');
    }
    
    public function loadImageInfo($id) {
        if (!$this->loadDB($id)) {
            Debugger::message(new \Exception("No such product!"));
        }
        try {
            $imageAsBase64 = 'data:image/gif;base64,'.base64_encode($this->userImageData);
            $data = ["x" => $this->x,
                "y" => $this->y,
                "width" => $this->width,
                "height" => $this->height,
                "id" => $this->id,
                "imageData" => $imageAsBase64];
        } catch (Exception $e) {
            Debugger::message($e);
        }
        return \Response::make(json_encode($data), 200);
    }



        private function generateThumb() {
        try {
            $imageData = file_get_contents(__DIR__ . "/../storage/images/shirt.png");
            $backgroundImage = \imagecreatefromstring($imageData);
            $destImage = \imagecreatetruecolor(imagesx($backgroundImage), imagesy($backgroundImage));
            \imagecopy($destImage, $backgroundImage, 0, 0, 0, 0, imagesx($backgroundImage), imagesy($backgroundImage));
            $foregroundImage = \imagecreatefromstring($this->userImageData);
            \imagecopyresampled($destImage, $foregroundImage, $this->x + 159, $this->y + 79, 0, 0, $this->width, $this->height, imagesx($foregroundImage), imagesy($foregroundImage));
            ob_start();
            imagepng($destImage);
            $this->thumb = ob_get_contents();
            ob_end_clean();
        } catch (\Exception $e) {
            Debugger::message($e);
        }
        return true;
    }

    private function decodeImageFromBase64($base64Data) {
        try {
            $headerPosition = strpos($base64Data, ';base64,');
            if ($headerPosition !== false) {
                $base64Data = substr($base64Data, $headerPosition + 8);
            }
            $decoded = base64_decode($base64Data);
        } catch (\Exception $e) {
            Debugger::message($e);
        }
        return $decoded;
    }

    private function resetData() {
        $this->id = '';
        $this->height = '';
        $this->width = '';
        $this->x = '';
        $this->y = '';
        $this->thumb = '';
        $this->userImageData = '';
        return true;
    }

    private function insertDB() {
        $pdo = \DB::getPdo();
        $query = "INSERT INTO tshirts (user_image_data,x,y,width,height,thumbnail) VALUES(" .
                ":user_image_data,:x,:y,:width,:height,:thumbnail)";

        try {
            $pdores = $pdo->prepare($query);
            $pdores->bindParam(':user_image_data', $this->userImageData, \PDO::PARAM_LOB);
            $pdores->bindParam(':x', $this->x, \PDO::PARAM_INT);
            $pdores->bindParam(':y', $this->y, \PDO::PARAM_INT);
            $pdores->bindParam(':width', $this->width, \PDO::PARAM_INT);
            $pdores->bindParam(':height', $this->height, \PDO::PARAM_INT);
            $pdores->bindParam(':thumbnail', $this->thumb, \PDO::PARAM_LOB);
            $pdores->execute();
        } catch (Exception $ex) {
            Debugger::message($ex);
        }
        $this->id = $pdo->lastInsertId();
        return true;
    }

    private function updateDB() {
        $query = "UPDATE tshirts SET user_image_data = '" . addcslashes($this->userImageData, "'") . "'," .
                "x =" . intval($this->x) . "," .
                "y =" . intval($this->y) . "," .
                "width=" . intval($this->width) . "," .
                "height=" . intval($this->height) . "," .
                "thumbnail='" . addcslashes($this->thumb, "'") . "' WHERE id=" . intval($this->id);
        try {
            $res = \mysql_query($query);
        } catch (Exception $ex) {
            Debugger::message($ex);
        }
        return true;
    }

    private function loadDB($id) {
        $pdo = \DB::getPdo();
        $query = "SELECT * FROM tshirts WHERE id=" . intval($id);
        try {
            $res = $pdo->query($query);
        } catch (Exception $ex) {
            Debugger::message($ex);
        }
        $results = [];

        foreach ($res as $record) {
            $results[] = $record;
        }

        if ($record = array_pop($results)) {
            $this->id = $id;
            $this->userImageData = $record["user_image_data"];
            $this->x = $record["x"];
            $this->y = $record["y"];
            $this->height = $record["height"];
            $this->width = $record["width"];
            $this->thumb = $record["thumbnail"];
            return true;
        }
        return false;
    }

}

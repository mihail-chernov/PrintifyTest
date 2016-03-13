<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class PrintifyController extends Controller {

    public function test() {
        return \Response::make("It's work!", 200);
    }

    public function addProduct(Request $request) {
        $imageBase64 = $request->input('imageBase64', '');
        $x = $request->input('imageX', '');
        $y = $request->input('imageY', '');
        $width = $request->input('imageWidth', '');
        $height = $request->input('imageHeight', '');

        $validationData = ['imageBase64' => $imageBase64, 'imageX' => $x, 'imageY' => $y, 'imageWidth' => $width, 'imageHeight' => $height];
        $validationRules = ['imageBase64' => 'required', 'imageX' => 'integer|required', 'imageY' => 'integer|required', 'imageWidth' => 'integer|required', 'imageHeight' => 'integer|required'];
        $validationMessages = ['integer' => 'Must be an integer'];
        $validation = \Validator::make($validationData, $validationRules, $validationMessages);
        if ($validation->fails()) {
            $messages = $validation->errors();
            $errors = '';
            foreach ($messages->all() as $message) {
                $errors .= "{$message}.\n";
            }
            return \Response::make($errors, 502);
        }
        if (strlen($imageBase64) <21 or strpos($imageBase64,'data:image/') === false) {
            \App\Debugger::message(new \Exception('Incorrect picture data!'));
        }
                
        $TshirtModel = new \App\TshirtImage();
        return $TshirtModel->addImage($x, $y, $width, $height, $imageBase64);
    }
    
    public function listProducts() {
        $shirtListModel = new \App\ShirtsList();
        return $shirtListModel->getShirts();
    }
    
    public function showThumb(Request $request) {
        $id = $request->input('id', '');
        $validationData = ['id' => $id];
        $validationRules = ['id' => 'required|integer'];
        $validationMessages = ['integer' => 'Must be an integer'];
        $validation = \Validator::make($validationData, $validationRules, $validationMessages);
        if ($validation->fails()) {
            $messages = $validation->errors();
            $errors = '';
            foreach ($messages->all() as $message) {
                $errors .= "{$message}.\n";
            }
            return \Response::make($errors, 502);
        }
        $TshirtModel = new \App\TshirtImage();
        return $TshirtModel->showThumb($id);
    }
    
    public function loadImage(Request $request) {
        $id = $request->input('id', '');
        $validationData = ['id' => $id];
        $validationRules = ['id' => 'required|integer'];
        $validationMessages = ['integer' => 'Must be an integer'];
        $validation = \Validator::make($validationData, $validationRules, $validationMessages);
        if ($validation->fails()) {
            $messages = $validation->errors();
            $errors = '';
            foreach ($messages->all() as $message) {
                $errors .= "{$message}.\n";
            }
            return \Response::make($errors, 502);
        }
        $TshirtModel = new \App\TshirtImage();
        return $TshirtModel->loadImage($id);        
    }
    
    public function loadImageInfo(Request $request) {
        $id = $request->input('id', '');
        $validationData = ['id' => $id];
        $validationRules = ['id' => 'required|integer'];
        $validationMessages = ['integer' => 'Must be an integer'];
        $validation = \Validator::make($validationData, $validationRules, $validationMessages);
        if ($validation->fails()) {
            $messages = $validation->errors();
            $errors = '';
            foreach ($messages->all() as $message) {
                $errors .= "{$message}.\n";
            }
            return \Response::make($errors, 502);
        }
        $TshirtModel = new \App\TshirtImage();
        return $TshirtModel->loadImageInfo($id);        
    }    

}

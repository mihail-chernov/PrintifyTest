<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Debugger extends Model {

    public static function message($exception) {
        $msg = $exception->getMessage();
        $traceInfo = $exception->getTraceAsString();
        $text = "<b>Error msg:</b>{$msg}\n" .
                "<b>Trace:</b>{$traceInfo}";
        \App::abort(501, $text);
    }

}

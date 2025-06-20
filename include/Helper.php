<?php
class Helper {
    public static function jsonOutput(int $code, string $message) {
        header("Content-Type:application/json");
        die(json_encode(['code' =>$code, 'message'=> $message]));
    }
    public static function jsonOutputNotas(int $code, array $notas) {
        header("Content-Type:application/json");
        die(json_encode(['code' =>$code, 'notas'=> $notas]));
    }
   
    
}
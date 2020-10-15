<?php

namespace app\Library;


class EnvironmentalConfirmation{


    public static function veryfyEnvironment(){
        
        return app()->environment();
    }


}
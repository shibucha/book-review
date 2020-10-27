<?php

namespace app\Library;


class EnvironmentalConfirmation{


    public function veryfyEnvironment(){
        
        return app()->environment();
    }


}
<?php

require_once('Amazon/Amazon_Base.php');
require_once('Amazon/Amazon_Config.php');
require_once('Amazon/Amazon_Get.php');
require_once('Amazon/Interfaces/I_Amazon.php');

class Amazon extends Amazon_Base implements I_Amazon {

    public function config() {
        return new Amazon_Config();
    }

    public function search($kw) {
        //Reflection, keeping _init hidden
        $class = new ReflectionClass(new Amazon_Base());
        $newClass = $class->getMethod("_init");
        $newClass->setAccessible(true);
        $newClass->invoke(new Amazon_Base(), $kw);
    }

    public function get() {
        return new Amazon_Get();
    }

    public function clear() {
        //Set private value _arrayData = null and _counter = 0 through reflection
        $privateVals = array("_arrayData" => null, "_counter" => 0);
        foreach ($privateVals as $k => $v) {
            $class = new ReflectionProperty(new Amazon_Base(), $k);
            $class->setAccessible(true);
            $class->setValue(new Amazon_Base(), $v);
        }
    }

}

?>
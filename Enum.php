<?php

abstract class Enum {
  
    /**
     * @return string
     */ 
    public static function getClassName() {
		return get_called_class();
	}

    /**
     * @return array
     */
    public static function getEnum() {
        return self::toArray();
    }

    /**
     * @return array
     */
    public static function toArray() {
        return self::getRef()->getConstants();
    }

    /**
     * @return ReflectionClass
     */
    public static function getRef() {
        return new ReflectionClass(self::getClassName());
    }

    /**
     * @return mixed|string
     */
    public static function toJson() {
        return json_encode(self::getEnum());
    }
}

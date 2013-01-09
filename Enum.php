<?php

abstract class Enum {
    /**
     * @var ReflectionClass
     */
    protected static $_refs;
    
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
        if (!self::$_refs) {
            self::$_refs = new ReflectionClass(self::getClassName());
        }
        return self::$_refs;
    }

    /**
     * @return mixed|string
     */
    public static function toJson() {
        return json_encode(self::getEnum());
    }
}

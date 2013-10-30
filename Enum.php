<?php

abstract class Enum {

    /**
     * @var mixed
     */
    private $value;

    /**
     * @deprecated("use valueOf() instead")
     * @param $value
     */
    public function __construct($value) {
        $this->setValue($value);
    }

    /**
     * @return string
     */
    public function __toString() {
        return (string) $this->getValue();
    }

    /**
     * @param $name
     * @param array $args
     * @return Enum
     */
    public static function __callStatic($name, array $args) {
        if (substr($name, 0, 3) == 'get') {
            $constant = strtoupper(substr($name, 3));
            if (self::exists($constant)) {
                return self::valueOf(self::value($constant));
            }
        }

        return parent::__callStatic($name, $args);
    }

    /**
     * @param $value
     * @return static
     */
    public static function valueOf($value) {
        return new static($value);
    }

    /**
     * @return string name of the constant
     */
    public function getName() {
        return array_search($this->getValue(), self::toArray(), true);
    }

    /**
     * @param $value
     * @return $this
     * @throws InvalidArgumentException
     */
    private function setValue($value) {
        if (!self::contains($value)) {
            throw new InvalidArgumentException();
        }

        $this->value = $value;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getValue() {
        return $this->value;
    }

    /**
     * @param Enum $enum
     * @return bool
     */
    public function equals(Enum $enum) {
        return (get_class($enum) == get_class($this) && $enum->getValue() === $this->getValue());
    }

    /**
     * @return ReflectionClass
     */
    private static function getRef() {
        return new ReflectionClass(get_called_class());
    }

    /**
     * @return array
     */
    public static function toArray() {
        return self::getRef()->getConstants();
    }

    /**
     * @return mixed|string
     */
    public static function toJson() {
        return json_encode(self::toArray());
    }

    /**
     * @param $value
     * @return bool
     */
    public static function contains($value) {
        return in_array($value, self::toArray());
    }

    /**
     * @param $constant
     * @return bool
     */
    public static function exists($constant) {
        return array_key_exists(strtoupper($constant), self::toArray());
    }

    /**
     * @param $constant
     * @return null
     */
    private static function value($constant) {
        return ifx(self::toArray(), strtoupper($constant));
    }

}

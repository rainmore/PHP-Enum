<?php
abstract class Enum {

    /**
     * @var array
     */
    private static $values;

    /**
     * @var mixed
     */
    private $value;

    public function __construct($value) {
        $this->setValue($value);
    }

    /**
     * @param $value
     * @return $this
     * @throws InvalidArgumentException
     */
    private function setValue($value) {
        if (!$this->contains($value)) {
            throw new InvalidArgumentException();
        }

        $this->value = $value;
        return $this;
    }

    /**
     * @return mixed
     */
    protected function getValue() {
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
        if (!self::$values) {
            self::$values = self::getRef()->getConstants();
        }
        return self::values;
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
     * @return string
     */
    public function __toString() {
        return (string) $this->getValue();
    }
}

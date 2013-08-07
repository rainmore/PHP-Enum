<?php
abstract class Enum {
    /**
     * @var ReflectionClass
     */
    protected static $_refs;

    private $value;

    public function __construct($value) {
        $this->setValue($value);
    }

    private function setValue($value) {
        if (!$this->contains($value)) {
            throw new InvalidArgumentException();
        }

        $this->value = $value;
        return $this;
    }

    protected function getValue() {
        return $this->value;
    }

    public function equals(Enum $enum) {
        return (get_class($enum) == get_class($this) && $enum->getValue() === $this->getValue());
    }

    /**
     * @return string
     */
    public static function getClassName() {
        return get_called_class();
    }

    /**
     * @return ReflectionClass
     */
    public static function getRef() {
        return new ReflectionClass(self::getClassName());
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

    public function __toString() {
        return (string) $this->getValue();
    }
}

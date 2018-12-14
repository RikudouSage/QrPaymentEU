<?php

namespace rikudou\EuQrPayment\Helper;

class Utils
{

    private static $constants = [];

    public static function getType($variable): string
    {
        if (is_object($variable)) {
            return get_class($variable);
        } else if (is_resource($variable)) {
            return "resource (" . get_resource_type($variable) . ")";
        } else {
            return gettype($variable);
        }
    }

    public static function getConstants(string $class)
    {

        if (!class_exists($class)) {
            throw new \InvalidArgumentException("The class '{$class}' is not defined");
        }

        if (!isset(static::$constants[$class])) {
            $reflection = new \ReflectionClass($class);
            static::$constants[$class] = $reflection->getConstants();
        }

        return static::$constants[$class];
    }

}
<?php
namespace Scaffolding\Service\Common;

class Util
{
    const TEMPLATE
        = "
======================================================================
   {message}
======================================================================
";

    /**
     * Convert string 'CamelCase' to 'camel-case'
     *
     * @param $action String
     * @return String
     */
    public static function toDashes($action)
    {
        $action = preg_replace('/(?<=\\w)(?=[A-Z])/', "-$1", $action);

        return strtolower($action);
    }

    /**
     * Format message for console output
     *
     * @param $message String
     * @return String
     */
    public static function format($message)
    {
        return str_replace('{message}', $message, self::TEMPLATE);
    }
}
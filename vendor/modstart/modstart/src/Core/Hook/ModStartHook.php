<?php


namespace ModStart\Core\Hook;


use ModStart\Core\Exception\BizException;

class ModStartHook
{
    private static $listeners = [];

    
    public static function subscribe($name, $callable)
    {
        if (!isset(self::$listeners[$name])) {
            self::$listeners[$name] = [];
        }
        self::$listeners[$name][] = $callable;
    }

    
    public static function get($name = '')
    {
        if (empty($name)) {
            return self::$listeners;
        }
        return array_key_exists($name, self::$listeners) ? self::$listeners[$name] : [];
    }

    
    public static function fire($name, &$param = null, $extra = null)
    {
        $results = [];
        foreach (static::get($name) as $key => $callable) {
            $results[$key] = self::call($callable, $name, $param, $extra);
        }
        return $results;
    }

    
    public static function fireInView($name, &$param = null, $extra = null)
    {
        return join('', self::fire($name, $param, $extra));
    }

    private static function call($callable, $name = '', &$param = null, $extra = null)
    {
        if ($callable instanceof \Closure) {
            $result = call_user_func_array($callable, [& $param, $extra]);
        } elseif (is_array($callable)) {
            list($callable, $method) = $callable;
            $result = call_user_func_array([&$callable, $method], [& $param, $extra]);
        } else if (is_object($callable)) {
            $method = "on$name";
            $result = call_user_func_array([&$callable, $method], [& $param, $extra]);
        } elseif (strpos($callable, '::')) {
            $result = call_user_func_array($callable, [& $param, $extra]);
        } else {
            BizException::throws('ModStartHook call error');
        }
        return $result;
    }
}

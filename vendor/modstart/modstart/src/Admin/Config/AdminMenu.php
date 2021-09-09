<?php


namespace ModStart\Admin\Config;


class AdminMenu
{
    private static $menu = [];

    public static function register($menu)
    {
        self::$menu[] = $menu;
    }

    public static function get()
    {
        $menu = [];
        foreach (self::$menu as $item) {
            if ($item instanceof \Closure) {
                $item = call_user_func($item);
            }
            $menu = array_merge($menu, $item);
        }
        return $menu;
    }
}

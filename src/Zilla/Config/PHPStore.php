<?php namespace Zilla\Config;

function array_set($array, $key, $value)
{
    $segments = explode($this->delimiter, $key);

    $items = &$this->items;

    foreach($segments as $segment)
    {
        $items = &$items[$segment];
    }

    $items = $value;
}

class PHPStore implements StoreInterface {

    protected $path;

    public function __construct($path)
    {
        $this->path = $path;
    }

    public function load($key)
    {
        $segments = explode('.', $key);

        $array = [];

        $path = $this->path;

        foreach($segments as $segment)
        {
            $path .= '/' . $segment;

            if(file_exists($path . '.php'))
            {
                $items = require $path . '.php';

                $array[$segment] = $items;

                return $array;
            }

            $array[$segment] = [];

            var_dump($array);
        }
    }

}

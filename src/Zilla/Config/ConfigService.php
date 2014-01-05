<?php namespace Zilla\Config;



class NullStore implements StoreInterface {

    public function load($key) {}

}


class ConfigService {

    protected $items;

    protected $store;

    protected $delimiter;

    public function __construct(array $items = array(), StoreInterface $store = null, $delimiter = '.')
    {
        $this->items = $items;

        $this->store = $store ?: new NullStore;

        $this->delimiter = $delimiter;
    }

    public function has($key)
    {
        return $this->fetch($key) ? true : false;
    }

    public function get($key, $default = null)
    {
        if($value = $this->fetch($key))
        {
            return $value;
        }
        else
        {
            $items = $this->store->load($key);

            if(is_array($items))
            {
                $this->items = array_merge($this->items, $items);

                return $this->fetch($key);
            }
        }

        return $default;
    }

    public function set($key, $value)
    {
        $segments = explode($this->delimiter, $key);

        $items = &$this->items;

        foreach($segments as $segment)
        {
            $items = &$items[$segment];
        }

        $items = $value;

        return $this;
    }

    protected function fetch($key)
    {
        $segments = explode($this->delimiter, $key);

        $items = $this->items;

        foreach($segments as $segment)
        {
            if(isset($items[$segment]))
            {
                $items = $items[$segment];
            }
            else
            {
                return false;
            }
        }

        return $items;
    }

    public function getStore()
    {
        return $this->store;
    }

    public function setStore(StoreInterface $store)
    {
        $this->store = $store;

        return $this;
    }

}

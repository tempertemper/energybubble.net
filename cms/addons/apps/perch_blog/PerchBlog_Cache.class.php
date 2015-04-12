<?php

class PerchBlog_Cache
{
    static private $instance;
    private $cache = array();
        
    public static function fetch()
    {       
        if (!isset(self::$instance)) {
            $c = __CLASS__;
             self::$instance = new $c;
        }

         return self::$instance;
    }
    
    public function exists($key)
    {
        return array_key_exists($key, $this->cache);
    }
    
    public function get($key)
    {
        if (array_key_exists($key, $this->cache)) {
            return $this->cache[$key];
        }
        
        return false;
    }
    
    public function set($key, $value)
    {
        $this->cache[$key] = $value;
    }
}

?>
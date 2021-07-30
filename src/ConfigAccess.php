<?php 
/**
 * 
 */

namespace Frootbox\Config;

/**
 * 
 */
class ConfigAccess implements \Iterator, \ArrayAccess
{
    protected $data;

    /**
     * 
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * 
     */
    public function __get($attribute)
    {
        if (!array_key_exists($attribute, $this->data)) {
            return null;
        }
        
        if (is_array($this->data[$attribute])) {
            return new self($this->data[$attribute]);
        }
        
        return $this->data[$attribute];
    }

    /**
     *
     */
    public function __isset($attribute): bool
    {
        return array_key_exists($attribute, $this->data);
    }


    /**
     *
     */
    public function current ( ) {

        return current($this->data);
    }


    /**
     *
     */
    public function getData ( ) {

        return $this->data;
    }


    /**
     *
     */
    public function key ( ) {

        return key($this->data);
    }


    /**
     *
     */
    public function next ( ) {

        next($this->data);
    }

    /**
     *
     */
    public function offsetExists($offset)
    {
        return array_key_exists($offset, $this->data);
    }

    /**
     *
     */
    public function offsetGet($offset)
    {
        if (!array_key_exists($offset, $this->data)) {
            return null;
        }

        return $this->data[$offset];
    }

    /**
     *
     */
    public function offsetSet($offset, $value)
    {
        d($this);
    }

    /**
     *
     */
    public function offsetUnset($offset)
    {
        d($this);
    }

    /**
     *
     */
    public function valid ( ) {

        return isset($this->data[key($this->data)]);
    }


    /**
     *
     */
    public function rewind ( ) {

        reset($this->data);
    }
    
    
    /**
     * 
     */
    public function append ( array $new ): ConfigAccess {


        $this->data = array_replace_recursive($this->data, $new);
        
        return $this;
    }


    /**
     *
     */
    public function appendFile ( string $filename ): ConfigAccess {

        $new = require $filename;

        $this->data = array_replace_recursive($this->data, $new);

        return $this;
    }

    /**
     *
     */
    public function unset ($key) {

        unset($this->data[$key]);
    }
}
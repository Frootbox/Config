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
    protected array $data;

    /**
     * 
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * @param string $attribute
     * @return mixed
     */
    public function __get(string $attribute): mixed
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
     * @param string $attribute
     * @return bool
     */
    public function __isset(string $attribute): bool
    {
        return array_key_exists($attribute, $this->data);
    }

    /**
     * @return mixed
     */
    public function current(): mixed
    {
        return current($this->data);
    }

    /**
     * @return array
     */
    public function getData(): array
    {
        return $this->data;
    }

    /**
     * @return mixed
     */
    public function key(): mixed
    {
        return key($this->data);
    }

    /**
     * @return void
     */
    public function next(): void
    {
        next($this->data);
    }

    /**
     * @param mixed $offset
     * @return bool
     */
    public function offsetExists(mixed $offset): bool
    {
        return array_key_exists($offset, $this->data);
    }

    /**
     * @param $offset
     * @return mixed
     */
    public function offsetGet($offset): mixed
    {
        if (!array_key_exists($offset, $this->data)) {
            return null;
        }

        return $this->data[$offset];
    }

    /**
     * @param mixed $offset
     * @param mixed $value
     * @return void
     */
    public function offsetSet(mixed $offset, mixed $value): void
    {
        d($this);
    }

    /**
     * @param mixed $offset
     * @return void
     */
    public function offsetUnset(mixed $offset): void
    {
        d($this);
    }

    /**
     * @return bool
     */
    public function valid(): bool
    {
        return isset($this->data[key($this->data)]);
    }

    /**
     * @return void
     */
    public function rewind(): void
    {
        reset($this->data);
    }

    /**
     * @param array $new
     * @return $this
     */
    public function append(array $new): ConfigAccess
    {
        $this->data = array_replace_recursive($this->data, $new);
        
        return $this;
    }

    /**
     * @param string $filename
     * @return $this
     */
    public function appendFile(string $filename): ConfigAccess
    {
        $new = require $filename;

        $this->data = array_replace_recursive($this->data, $new);

        return $this;
    }

    /**
     * @param $key
     * @return void
     */
    public function unset($key): void
    {
        unset($this->data[$key]);
    }
}

<?php 
/**
 * @author Jan Habbo Brüning <jan.habbo.bruening@gmail.com> 
 * @date 2018-06-15
 * 
 * @package Frootbox/Config
 */

namespace Frootbox\Config;

/**
 * 
 */
class Config implements Interfaces\Base
{
    protected ConfigAccess $configuration;

    /**
     * @Inject({"config.file"})
     */
    public function __construct(string $file = null)
    {
        if (!empty($file)) {
            $this->load($file);            
        }
        else {
            $this->configuration = new ConfigAccess([]);
        }

        if ($includes = $this->get('includes')) {

            foreach ($includes as $index) {

                $this->configuration->appendFile($index);
            }
        }
    }

    /**
     * @param string $attribute
     * @return mixed
     */
    public function __get(string $attribute ): mixed
    {
        return $this->configuration->$attribute;
    }

    /**
     * Append config data
     */
    public function append(array $data): void
    {
        $this->configuration->append($data);
    }

    /**
     * Unset config data
     */
    public function unset($key): void
    {
        $this->configuration->unset($key);
    }

    /**
     * 
     */
    public function clearCaches(): void
    {
        // d($this->get('cacheRootFolder'));
    }

    /**
     * @param string $configpath
     * @return mixed
     */
    public function get(string $configpath): mixed
    {
        $request = explode('.', $configpath);
        
        $config = $this->configuration;

        foreach ($request as $segment) {
            
            if ($config->$segment === null) {
                return null;
            }
            
            if ($config->$segment instanceof \Frootbox\Config\ConfigAccess) {
               $config = $config->$segment;
               continue;
            }
            
            return $config->$segment;            
        }

        return $config;
    }

    /**
     * 
     */
    public function load(string $filepath): void
    {
        if (!file_exists($filepath)) {
            throw new \Frootbox\Exceptions\ResourceMissing('Config file not loadable.');
        }
        
        $this->configuration = new ConfigAccess(require $filepath);
    }

    /**
     * Prepend data to configuration
     */
    public function prepend()
    {
        
    }
}

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
class Config implements Interfaces\Base {
    
    /**
     * 
     */
    protected $configuration;

    /**
     * @Inject({"config.file"})
     */
    public function __construct ( $file ) {

        if (!empty($file)) {
            $this->load($file);            
        }

        if ($includes = $this->get('includes')) {

            foreach ($includes as $index) {

                $this->configuration->appendFile($index);
            }
        }
    }

    
    /**
     * 
     */
    public function __get ( $attribute ) {

        return $this->configuration->$attribute;
    }
    
    
    /**
     * Append config data
     */
    public function append ( $data ): Config {
        
        $this->configuration->append($data);
        
        return $this;
    }
    
    
    /**
     * 
     */
    public function clearCaches ( ): Config {
        
        // d($this->get('cacheRootFolder'));
        
        return $this;
    }
    
    
    /**
     * 
     */
    public function get ( $configpath ) {

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
    public function load ( $filepath ) {
        
        if (!file_exists($filepath)) {
            throw new \Frootbox\Exceptions\ResourceMissing('Config file not loadable.');
        }
        
        $this->configuration = new ConfigAccess(require $filepath);
    }
    
    
    /**
     * Prepend data to configuration
     */
    public function prepend ( ) {
        
    }
}
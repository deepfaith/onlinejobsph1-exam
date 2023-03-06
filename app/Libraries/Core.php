<?php

namespace Libraries;

/**
 * App Core Class
 * Creates URL & loads core controller
 * URL FORMAT - /controller/method/params
 */
class Core
{
    /**
     * Current Controller default Pages
     * @var mixed|string
     */
    protected $currentController = 'Pages';
    /**
     * Current Method default index
     * @var string
     */
    protected $currentMethod = 'index';
    /**
     * URI parameters
     * @var array|false|string[]|void
     */
    protected $params = [];

    public function __construct()
    {
        $url = $this->getUrl();

        // Look for controller
        if (file_exists('../app/Controllers/' . ucwords($url[0]) . '.php')) {
            // If exists, set as controller
            $this->currentController = ucwords($url[0]);
            // Unset index 
            unset($url[0]);
        }

        // Instantiate controller class
        $namespace = '\\Controllers';
        $class_name = $this->currentController;
        $fully_qualified_class_name = "$namespace\\$class_name";
        $this->currentController = new $fully_qualified_class_name;

        // Check for url[1] - method
        if (isset($url[1])) {
            // Check to see if method exists in controller
            if (method_exists($this->currentController, $url[1])) {
                $this->currentMethod = $url[1];
                // Unset index
                unset($url[1]);
            }
        }

        // Get params
        $this->params = $url ? array_values($url) : [];

        // Callback with array of params
        call_user_func_array([$this->currentController, $this->currentMethod], $this->params);
    }

    /**
     * Get the url for routing
     * @return false|string[]|void
     */
    public function getUrl()
    {
        if (isset($_GET['url'])) {
            $url = rtrim($_GET['url'], '/');
            $url = filter_var($url, FILTER_SANITIZE_URL);
            return explode('/', $url);
        }
    }
}

<?php

namespace Libraries;

/**
 * Base Controller
 * Loads the models and views
 */
class Controller
{

    /**
     *  Load view
     * @param $view
     * @param $data
     * @return void
     */
    public function view($view, $data = [])
    {
        // Check for the view file
        if (file_exists('../app/views/' . $view . '.php')) {
            require_once '../app/views/' . $view . '.php';
        } else {
            // View not found
            die('View does not exist');
        }
    }
}

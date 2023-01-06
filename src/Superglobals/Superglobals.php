<?php

namespace App\Superglobals;

class Superglobals
{

    private $SERVER;

    private $POST;

    private $GET;

    private $SESSION;


    /**
     * Constructor
     *
     * @return void
     */
    public function __construct()
    {
        $this->define_superglobals();

        // End __construct().
    }
    

    /**
     * Returns a key from the superglobal,
     * as it was at the time of instantiation.
     *
     * @param $key
     * @return mixed
     */
    public function get_SERVER($key = null)
    {
        if ($key !== null) {
            return (isset($this->SERVER["$key"])) ? $this->SERVER["$key"] : null;
        } else {
            return $this->SERVER;
        }
    }

    /**
     * Returns a key from the superglobal,
     * as it was at the time of instantiation.
     *
     * @param $key
     * @return mixed
     */
    public function get_POST($key = null)
    {
        if ($key !== null) {
            return (isset($this->POST["$key"])) ? $this->POST["$key"] : null;
        } else {
            return $this->POST;
        }
    }

    /**
     * Returns a key from the superglobal,
     * as it was at the time of instantiation.
     *
     * @param $key
     * @return mixed
     */
    public function get_GET($key = null)
    {
        if ($key !== null) {
            return (isset($this->GET["$key"])) ? $this->GET["$key"] : null;
        } else {
            return $this->GET;
        }
    }

    /**
     * Returns a key from the superglobal,
     * as it was at the time of instantiation.
     *
     * @param $key
     * @return mixed
     */
    public function get_SESSION($key = null)
    {
        if ($key !== null) {
            return (isset($this->SESSION["$key"])) ? $this->SESSION["$key"] : null;
        } else {
            return $this->SESSION;
        }
    }

    /**
     * Function to define superglobals for use locally.
     * We do not automatically unset the superglobals after
     * defining them, since they might be used by other code.
     *
     * @return mixed
     */
    private function define_superglobals()
    {

        // Store a local copy of the PHP superglobals
        // This should avoid dealing with the global scope directly
        // $this->_SERVER = $_SERVER.
        $this->SERVER = (isset($_SERVER)) ? $_SERVER : null;
        $this->POST = (isset($_POST)) ? $_POST : null;
        $this->GET = (isset($_GET)) ? $_GET : null;
        $this->SESSION = (isset($_SESSION)) ? $_SESSION : null;
        /*$this->GET = filter_input_array(INPUT_GET) ?? null;
        $this->POST = filter_input_array(INPUT_POST) ?? null;*/
        /*var_dump($this);
        die;*/

    }

    /**
     * You may call this function from your compositioning root,
     * if you are sure superglobals will not be needed by
     * dependencies or outside of your own code.
     *
     * @return void
     */
    public function unset_superglobals()
    {
        unset($_SERVER);
        unset($_POST);
        unset($_GET);
        unset($_SESSION);
    }

}

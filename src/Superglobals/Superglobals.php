<?php

namespace App\Superglobals;

use Symfony\Component\HttpFoundation\Request;

class Superglobals
{

    /**
     * Envs
     *
     * @var mixed $server
     */
    private $server;

    /**
     * Envs
     *
     * @var mixed $post
     */
    private $post;

    /**
     * Envs
     *
     * @var mixed $get
     */
    private $get;

    /**
     * Envs
     *
     * @var mixed $session
     */
    private $session;

    /**
     * Envs
     *
     * @var mixed $instance
     */
    private static $instance;


    /**
     * Constructor
     *
     * @param $get Get
     * @param $post Post
     * @param $server Server
     * @param $session Session
     */
    private function __construct($get, $post, $server, $session)
    {
        $this->server = $server ?? [];
        $this->post = $post ?? [];
        $this->get = $get ?? [];
        $this->session = $session ?? [];

        // End __construct().
    }


    public static function get()
    {
        $request = Request::createFromGlobals();

        if (!(self::$instance instanceof self)) {
            self::$instance = new self($request->query->all(), $request->request->all(), $request->server->all(), $_SESSION);
        }

        return self::$instance;
    }


    /**
     * Returns a key from the superglobal,
     * as it was at the time of instantiation.
     *
     * @param $key Key
     * @return mixed
     */
    public function getServer($key=null)
    {
        if (array_key_exists($key, $this->server)) {
            return $this->server[$key];
        }

        return $this->server;
    }


    /**
     * Returns a key from the superglobal,
     * as it was at the time of instantiation.
     *
     * @param $key Key
     * @return mixed
     */
    public function getPost($key=null)
    {
        if (array_key_exists($key, $this->post)) {
            return $this->post[$key];
        }

        return $this->post;
    }

    /**
     * Returns a key from the superglobal,
     * as it was at the time of instantiation.
     *
     * @param $key Key
     * @return mixed
     */
    public function getGet($key=null)
    {
        if (array_key_exists($key, $this->get)) {
            return $this->get[$key];
        }

        return $this->get;
    }

    /**
     * Returns a key from the superglobal,
     * as it was at the time of instantiation.
     *
     * @param $key
     * @return mixed
     */
    public function getSession($key=null)
    {
        if (array_key_exists($key, $this->session)) {
            return $this->session[$key];
        }

        return $this->session;
    }


}

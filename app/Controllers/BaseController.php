<?php

namespace App\Controllers;


use CodeIgniter\Controller;
use CodeIgniter\HTTP\CLIRequest;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

/**
 * Class BaseController
 *
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 * Extend this class in any new controllers:
 *     class Home extends BaseController
 *
 * For security be sure to declare any new methods as protected or private.
 */
abstract class BaseController extends Controller
{
    /**
     * Instance of the main Request object.
     *
     * @var CLIRequest|IncomingRequest
     */
    public $request;
    public $session;
    public $db;
    public $router;
    public $error;
    public $settings;
    public $paypara;
    public $SecureModel;
    public $JsObfuscator;
    public $agent;
    public $uri;

    /**
     * An array of helpers to be loaded automatically upon
     * class instantiation. These helpers will be available
     * to all other controllers that extend BaseController.
     *
     * @var array
     */
    protected $helpers = ['cookie', 'app', 'string', 'user', 'dashboard', 'jsObfuscator'];

    /**
     * Constructor.
     */
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // Do Not Edit This Line
        parent::initController($request, $response, $logger);

        $this->Init = new \App\Libraries\Init($this->request);
        $this->Init->prepare();

        $this->session          = $this->Init->session;
        $this->router           = $this->Init->router;
        $this->db               = $this->Init->db;
        $this->settings         = $this->Init->settings;
        $this->paypara          = $this->Init->paypara;
        $this->error            = $this->Init->error;
        $this->JsObfuscator     = $this->Init->JsObfuscator;
        $this->SecureModel      = $this->Init->SecureModel;
        $this->agent            = $this->Init->agent;
        $this->uri              = $this->Init->uri;
    }
}
<?php

namespace Gentor\Etsy\Exceptions;


/**
 * Class EtsyResponseException
 * @package Gentor\Etsy\Exceptions
 */
class EtsyResponseException extends \Exception
{
    /**
     * @var mixed
     */
    private $response;

    /**
     * EtsyResponseException constructor.
     * @param string $message
     * @param mixed $response
     */
    function __construct($message, $response = [])
    {
        $this->response = $response;

        parent::__construct($message);
    }

    /**
     * @return mixed
     */
    public function getResponse()
    {
        return $this->response;
    }
}

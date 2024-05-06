<?php

declare(strict_types=1);


namespace App\Controller;

use Hyperf\HttpServer\Contract\RequestInterface;
use Hyperf\HttpServer\Contract\ResponseInterface;
use Psr\Container\ContainerInterface;

abstract class AbstractController
{
    protected ContainerInterface $container;

    protected RequestInterface $request;

    protected ResponseInterface $response;

    public function __construct(
        ResponseInterface  $response,
        RequestInterface   $request,
        ContainerInterface $container
    )
    {
        $this->response = $response;
        $this->request = $request;
        $this->container = $container;
    }
}

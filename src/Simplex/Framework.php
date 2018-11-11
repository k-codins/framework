<?php

namespace Simplex;

use Exception;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Controller\ArgumentResolver;
use Symfony\Component\HttpKernel\Controller\ControllerResolver;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\Routing\Matcher\UrlMatcher;

class Framework
{
    /**
     * @var UrlMatcher
     */
    private $matcher;

    /**
     * @var ControllerResolver
     */
    private $controllerResolver;

    /**
     * @var ArgumentResolver
     */
    private $argumentResolver;

    function __construct(UrlMatcher $matcher, ControllerResolver $controllerResolver, ArgumentResolver $argumentResolver)
    {
        $this->matcher = $matcher;
        $this->controllerResolver = $controllerResolver;
        $this->argumentResolver = $argumentResolver;
    }

    public function handle(Request $request): Response
    {
        $this->matcher->getContext()->fromRequest($request);

        try {
            $request->attributes->add($this->matcher->match($request->getPathInfo()));
            //get controller from request argument '_controller'
            $controller = $this->controllerResolver->getController($request);
            //get arguments inject necessary arguments when it type-hinted correctly.
            $arguments = $this->argumentResolver->getArguments($request, $controller);

            $response = call_user_func_array($controller, $arguments);
        } catch (ResourceNotFoundException $exception) {
            $response = new Response('Not found', 404);
        } catch (Exception $exception) {
            $response = new Response('An error occured', 500);
        }
        return $response;
    }
}

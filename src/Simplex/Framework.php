<?php

namespace Simplex;

use Exception;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Controller\ArgumentResolverInterface;
use Symfony\Component\HttpKernel\Controller\ControllerResolverInterface;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\Routing\Matcher\UrlMatcherInterface;

class Framework
{
    /**
     * @var UrlMatcherInterface
     */
    private $matcher;

    /**
     * @var ControllerResolverInterface
     */
    private $controllerResolver;

    /**
     * @var ArgumentResolverInterface
     */
    private $argumentResolver;

    /**
     * Framework constructor.
     * @param UrlMatcherInterface $matcher
     * @param ControllerResolverInterface $controllerResolver
     * @param ArgumentResolverInterface $argumentResolver
     */
    function __construct(UrlMatcherInterface $matcher, ControllerResolverInterface $controllerResolver, ArgumentResolverInterface $argumentResolver)
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

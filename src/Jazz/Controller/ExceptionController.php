<?php

namespace Jazz\Controller;

use Symfony\Component\HttpKernel\Debug\ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\FlattenException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @package Jazz
 */
class ExceptionController extends Controller
{
    /**
     * @param Request $request
     * @param FlattenException $exception
     * @param string $format
     */
    public function showAction(Request $request, FlattenException $exception, $format)
    {
        $handler = new ExceptionHandler($this->app['debug']);

        if ($this->app['debug']) {
            return $handler->createResponse($exception);
        }

        $code = $exception->getStatusCode();
        $template = $this->resolve($request, $code, $format);

        if ($template) {
            $contents =  $this->app['twig']->render($template, array(
                'status_code'    => $code,
                'status_text'    => isset(Response::$statusTexts[$code]) ? Response::$statusTexts[$code] : '',
                'exception'      => $exception,
            ));

            return new Response($contents, $code);
        }

        return $handler->createResponse($exception);
    }

    /**
     * @param Request $request
     * @param integer $code
     * @param string $format
     * @return string|null
     */
    protected function resolve(Request $request, $code, $format)
    {
        $loader = $this->app['twig.loader'];

        $templates = array(
            'Exception/error' . $code . '.' . $format . '.twig',
            'Exception/error.' . $format . '.twig',
            'Exception/error.html.twig',
            '@Flint/Exception/error.' . $format . '.twig',
            '@Flint/Exception/error.html.twig',
        );

        foreach ($templates as $template) {
            if (false == $loader->exists($template)) {
                continue;
            }

            if (strpos($template, '.html.twig')) {
                $request->setRequestFormat('html');
            }

            return $template;
        }
    }
}

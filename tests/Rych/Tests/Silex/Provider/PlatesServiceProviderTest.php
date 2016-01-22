<?php

namespace Rych\Tests\Silex\Provider;

use League\Plates\Engine;
use Silex\Application;
use Rych\Silex\Provider\PlatesServiceProvider;
use Symfony\Component\HttpFoundation\Request;

class PlatesServiceProviderTest extends \PHPUnit_Framework_TestCase
{

    /** @var  Application */
    protected $app;

    public function testContainer()
    {
        $this->makeApp();
        $this->assertInstanceOf(Engine::class, $this->app['plates']);
        $this->assertInstanceOf(Engine::class, $this->app['plates.engine']);
    }

    public function testRegisterAndRender()
    {
        $this->makeApp();
        $this->app->get('/hello/{name}', function ($name) {
            return $this->plates()->render('hello', compact('name'));
        });

        $request = Request::create('/hello/john');
        $response = $this->app->handle($request);
        $this->assertEquals('Hello john!', $response->getContent());
    }

    public function testRenderFolders()
    {
        $this->makeApp(
            [
                'plates.folders' => [
                    'email' => __DIR__ . '/../../../../Resources/view-folders/email',
                ]
            ]
        );


        $this->app->get('/email/{name}', function ($name) {
            return $this->plates()->render('email::salutations', array('name' => $name));
        });

        $request = Request::create('/email/john');
        $response = $this->app->handle($request);
        $this->assertEquals('Dear john,', $response->getContent());
    }

    /**
     * @return Engine
     */
    protected function plates()
    {
        return $this->app['plates'];
    }

    protected function makeApp(array $values = [])
    {
        $this->app = new Application();
        $this->app['debug'] = true;
        $values = array_merge([
            'plates.path' => __DIR__ . '/../../../../Resources/views',
        ], $values
        );
        $this->app->register(new PlatesServiceProvider(), $values);
    }
}


<?php

namespace Test\Unit;

use App\Exceptions\RouteNotFoundException;
use App\Router;
use PHPUnit\Framework\TestCase;

class RouterTest extends TestCase {

    private Router $router;

    public function setUp(): void
    {
        Parent::setUp();

        $this->router = new Router;
    }

    /** @test */
    public function does_our_register_method_work(): void
    {
        //given we have a route object
        //$router = new Router();

        //when we call a register method
        $this->router->register('/users', 'GET', ['users', 'index']);

        //then we assert that a route was registered
        //assertEquals compares if we get the expected value
        $expected = [
            'GET' => [
                '/users' => ['users', 'index']
            ]
        ];

        $this->assertEquals($expected, $this->router->routes());
    }

    /** @test */
    public function it_registers_a_get_route(): void
    {
       //given we have a route
       //$route = new Router;

       //when we call get method
       $actual = $this->router->get('/users', ['users', 'index']);

       //asset that the get method returns a router object

       $expected = $this->router;

       $this->assertEquals($expected, $actual);
    }

    /** @test */
    public function there_is_no_route_when_route_is_created(): void
    {
        $route = new Router;

        //dont use this->router bcoz it may have been instatiated when we do the above tests

        $this->assertEmpty($route->routes());
    }

    /** 
     * @test 
     * @dataProvider routeNotFoundCases
     * 
    */
    public function it_throws_route_not_found_exception(string $request_method, string $request_uri)
    {
        $class = new class(){
            public function delete()
            {
                return true;
            }
        };

        

        $this->router->post('/users',[$class::class, 'stores']);
        $this->router->get('/users',['users', 'index']);

        $this->expectException(RouteNotFoundException::class);

        $this->router->resolve($request_method, $request_uri);

        

    }


    public function routeNotFoundCases(): array
    {
        return [
            ['PUT', '/users'],
            ['POST', '/invoices'],
            ['PATCH', '/users'],
            ['POST', '/users']
        ];
    }
}
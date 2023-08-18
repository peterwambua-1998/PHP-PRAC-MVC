<?php

namespace App;

use App\Exceptions\RouteNotFoundException;
use App\Interfaces\PaymentGatewayServiceInterface;
use App\Router;
use App\Service\EmailService;
use App\Service\InvoiceService;
use App\Service\PaymentGatewayService;
use App\Service\SalesTaxService;
use PDO;

class App 
{
    protected static \PDO $db;
    public static Container $container;

    public function __construct(protected Router $router, protected array $request, $container) {
        try {
            static::$db = new PDO(
                'mysql:host='.$_ENV['DB_HOST']. ';dbname='.$_ENV['DB_DATABASE'],
                $_ENV['DB_USER'],
                $_ENV['DB_PASS']
            );
        } catch (\PDOException $th) {
            throw new \PDOException($th->getMessage(), (int) $th->getCode());
        }

        static::$container = $container;
        
        static::$container->set(PaymentGatewayServiceInterface::class, PaymentGatewayService::class);
    }
    /**
     * create instance of db so but this is not effective 
     * we will use DI Container
     */
    public function DB(): \PDO
    {
        return static::$db;
    }

    public function run()
    {
        try {
            $this->router->resolve($this->request['REQUEST_METHOD'], $this->request['REQUEST_URI']);
        } catch (RouteNotFoundException $th) {
            echo $th->getMessage();
        }
    }
}
<?php 

namespace App;

use App\Exceptions\RouteNotFoundException;

class View {
    const BASEDIR = __DIR__ . '/../views/';


    public static function render(string $name, array $params = [])
    {
        
        $viewFile = self::BASEDIR . $name . '.php';

        if (! file_exists($viewFile)) {
            throw new RouteNotFoundException('404 not found');
        }

        ob_start();
        
        include $viewFile;

        echo ob_get_clean();
    }
}
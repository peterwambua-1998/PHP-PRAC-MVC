<?php 
/**
 * TODO
 * add singleton support
 */
namespace App;

use App\Exceptions\ContainerException;
use Psr\Container\ContainerInterface;
use ReflectionClass;

class Container implements ContainerInterface {
    private array $entries = [];

    public function get(string $id) 
    {
        if ($this->has($id)) {
            $entry = $this->entries[$id];
            if (is_callable($entry)) {
                return $entry($this);
            }
            $id = $entry;
        }

        return $this->resolve($id);
    }

    public function has(string $id): bool
    {
        return isset($this->entries[$id]);
    }

    public function set(string $id, callable|string $concrete): void
    {
        $this->entries[$id] = $concrete;
    }

    public function resolve(string $id)
    {
        // 1. get the class
        $reflectionClass = new ReflectionClass($id);
        if (!$reflectionClass->isInstantiable()) {
            throw new ContainerException("class " .$id. " is not instantiable");
        }

        // 2. get constructor
        $constructor = $reflectionClass->getConstructor();
        if (! $constructor) {
            return new $id;
        }

        // 3. check if it has parameters
        $parameters = $constructor->getParameters();
        if (! $parameters) {
            return new $id;
        } 

        $dependencies = [];

        // 4 . loop through the parameters and resolve using container
        foreach ($parameters as $key => $param) {
            $type = $param->getType();
            $name = $param->getName();

            if (! $type) {
                throw new ContainerException("class " .$name. " is missing type hint");
            }
            //check if built in 

            if ($type instanceof \ReflectionUnionType) {
                throw new ContainerException("class " .$name. " because of union type parameter");
            }

            if ($type instanceof \ReflectionNamedType && ! $type->isBuiltin()) {
                $result = $this->get($type->getName());
                array_push($dependencies, $result);
            }
        } 

        return $reflectionClass->newInstanceArgs($dependencies);
    }
}

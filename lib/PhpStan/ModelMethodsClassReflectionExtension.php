<?php

namespace ActiveRecord\PhpStan;

use ActiveRecord\Model;
use PHPStan\Reflection\ClassReflection;
use PHPStan\Reflection\MethodReflection;
use PHPStan\Reflection\MethodsClassReflectionExtension;

class ModelMethodsClassReflectionExtension implements MethodsClassReflectionExtension
{
    public function hasMethod(ClassReflection $classReflection, string $methodName): bool
    {
        if ($classReflection->isSubclassOf(Model::class)) {
            if (preg_match('/\bfind_(all_)?by_/', $methodName)) {
                return true;
            }

            if (preg_match('/\bcount_by_/', $methodName)) {
                return true;
            }

            if (str_ends_with($methodName, '_set')) {
                return true;
            }
        }

        return false;
    }

    public function getMethod(ClassReflection $classReflection, string $methodName): MethodReflection
    {
        return new ModelStaticMethodReflection($classReflection, $methodName);
    }
}

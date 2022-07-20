<?php

namespace Chiron\Support;

//https://github.com/getsentry/sentry-php/blob/79f2db68cd556fdb5600b7425a73712c40a2eff1/src/Serializer/AbstractSerializer.php#L299

// TODO : ajouter une possibilité de faire un safe invoke en wrappant l'appel dans un error handler :
// https://github.com/nette/utils/blob/master/src/Utils/Callback.php#L26
// https://github.com/nette/safe/blob/7dff38894a027d04a22044933c2713f53154cc48/src/Safe.php#L2486

final class Callback
{
    /**
     * Converts PHP callback to textual form. Class or method may not exists.
     * @param mixed $callable Argument could be mixed but it's more logical to expect a valid callable.
     */
    public static function toString($callable): string
    {
        if ($callable instanceof \Closure) {
            $inner = self::unwrap($callable);
            return '{closure' . ($inner instanceof \Closure ? '}' : ' ' . self::toString($inner) . '}');
        } else {
            is_callable(is_object($callable) ? [$callable, '__invoke'] : $callable, true, $textual);
            return $textual;
        }
    }

    /**
     * Unwraps closure created by Closure::fromCallable().
     * @return \Closure|array|string Can return an array in case of Closure::fromCallable[$this, 'my_private_method']
     */
    public static function unwrap(\Closure $closure)
    {
        $r = new \ReflectionFunction($closure);

        // If you call getName() on an anonymous function you'll get "{closure}".
        if (str_ends_with($r->name, '}')) {
            return $closure;
        } elseif ($obj = $r->getClosureThis()) {
            return [$obj, $r->name];
        } elseif ($class = $r->getClosureScopeClass()) {
            return [$class->name, $r->name];
        } else {
            return $r->name;
        }
    }


    /*
// TODO : utiliser ce bout de code et lever une exception si ce n'est pas un callable valide (throw InjectionException::fromInvalidCallable(xxx);)
//https://github.com/rdlowrey/auryn/blob/master/lib/InjectionException.php
//https://github.com/rdlowrey/auryn/blob/master/lib/Injector.php#L237
    private function isExecutable($exe)
    {
        if (is_callable($exe)) {
            return true;
        }
        if (is_string($exe) && method_exists($exe, '__invoke')) {
            return true;
        }
        if (is_array($exe) && isset($exe[0], $exe[1]) && method_exists($exe[0], $exe[1])) {
            return true;
        }

        return false;
    }
*/
}

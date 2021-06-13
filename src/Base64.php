<?php

namespace Chiron\Support;

use InvalidArgumentException;

// TODO : renommer la classe en Base64UrlSafe

//https://github.com/ElfSundae/urlsafe-base64/blob/master/src/helpers.php


// BASE62 :
// https://snipplr.com/view/22246/base62-encode--decode
// https://programanddesign.com/php/base62-encode/
// https://github.com/daqimei/base62/blob/master/src/Base62.php
// https://github.com/songying/Base62/blob/master/base62.php
// https://github.com/breenie/base62/blob/master/src/Kurl/Maths/Encode/Driver/PurePhpEncoder.php
// https://gist.github.com/jgrossi/a4eb21bbe00763d63385
// https://github.com/vinkla/base62/blob/master/src/Base62.php

// TODO : sinon utiliser dechex et hexdec en repmplacement de la fonction Base62 pour réduire les integers

// BASE 64 :
// https://base64.guru/developers/php/examples/base64url
// https://github.com/firebase/php-jwt/blob/master/src/JWT.php#L333
// https://www.php.net/manual/fr/function.base64-decode.php#118244

// TODO : Random exemple de classes : https://github.com/phalcon/phalcon/blob/569afa77b84d4907f121fef16a0db88c22d52ef7/src/Support/Str/Random.php
// https://github.com/phalcon/cphalcon/blob/634e7233a86780c9509614a8d835b188c8be76e5/phalcon/Security/Random.zep
// https://github.com/phalcon/cphalcon/blob/81561d8abd33449458c99873d2ddaeaa7832ebd0/phalcon/Helper/Str.zep#L611
// https://github.com/ircmaxell/RandomLib/blob/master/lib/RandomLib/Generator.php#L118

// TODO : exemple pour SIGNER les cookies.
// https://docs.djangoproject.com/en/3.0/_modules/django/core/signing/
// https://github.com/tj/node-cookie-signature/blob/master/index.js
// TODO : vérification si le SIGNED cookie commence bien par "s:"
//https://github.com/expressjs/cookie-parser/blob/master/index.js#L134
//https://github.com/balderdashy/sails/blob/53d0473c2876b1925136f777cb51ac9eda5b24aa/lib/hooks/session/index.js#L513

// TODO : exemple pour vérifier les cookies signés (doivent commencer par 's:')
//https://github.com/balderdashy/sails/blob/53d0473c2876b1925136f777cb51ac9eda5b24aa/lib/hooks/session/index.js#L481
//https://github.com/expressjs/cookie-parser/blob/master/index.js#L129
//https://github.com/expressjs/session/blob/master/index.js#L656


//https://github.com/ircmaxell/RandomLib/blob/master/lib/RandomLib/Generator.php

//https://github.com/hackzilla/password-generator/blob/master/Generator/ComputerPasswordGenerator.php#L38
//https://github.com/icecave/abraxas/blob/e969b3683817e1c779297d195bfda37ba6ddcace/src/PasswordGenerator.php#L123
//https://github.com/mrhewitt/php-utils/blob/dd842f263339ba4e6003ff981299fa7b45140dfa/src/MarkHewitt/Util/PWGen.php#L394

//https://paragonie.com/blog/2015/07/common-uses-for-csprngs-cryptographically-secure-pseudo-random-number-generators
//https://paragonie.com/blog/2015/07/how-safely-generate-random-strings-and-integers-in-php


//https://docs.phalcon.io/4.0/fr-fr/api/phalcon_security#security-random

/*
$random = new Random();

// ...
$bytes      = $random->bytes();

// Generate a random hex string of length $len.
$hex        = $random->hex($len);

// Generate a random base64 string of length $len.
$base64     = $random->base64($len);

// Generate a random URL-safe base64 string of length $len.
$base64Safe = $random->base64Safe($len);

// Generate a UUID (version 4).
// See https://en.wikipedia.org/wiki/Universally_unique_identifier
$uuid       = $random->uuid();

// Generate a random integer between 0 and $n.
$number     = $random->number($n);
*/

// TODO : renommer la classe en "Security", et créer 2 méthode generateKey() qui retourn un randombyte et un generateId ou uniqueId qui génére une string aléatoire. Et aussi créer la méthode randomString($length, $alphabet) avec des constante pluc dans classe (style UPPER/LOWER/SYMBOLS/AMBIGUOIUS etc...)

// TODO : créer des méthodes globales (dans functions.php) style uuid() ou generate_key() et random_id() et sign() et unsign() pour simplifier l'utilisation de ces méthodes !!!

// TODO : créer une classe Strings ou Str dans le package chiron/core (répertoire Support) qui aurait une méthode base64UrlEncode/Decode
// TODO : renommer la classe en Base64Safe.
final class Base64
{
    /**
     * Encode data to Base64URL
     * @param string $data
     * @return boolean|string
     */
    public static function encode(string $data)
    {
      // First of all you should encode $data to Base64 string
      $b64 = base64_encode($data);

      // Make sure you get a valid result, otherwise, return FALSE, as the base64_encode() function do
      if ($b64 === false) {
        return false;
      }

      // Convert Base64 to Base64URL by replacing “+” with “-” and “/” with “_”
      $url = strtr($b64, '+/', '-_');

      // Remove padding character from the end of line and return the Base64URL result
      return rtrim($url, '=');
    }

    /**
     * Decode data from Base64URL
     * @param string $data
     * @param boolean $strict
     * @return boolean|string
     */
    public static function decode(string $data, bool $strict = false)
    {
      // Convert Base64URL to Base64 by replacing "-"" with "+" and "_" with "/"
      $b64 = strtr($data, '-_', '+/');

      // Decode Base64 string and return the original data
      return base64_decode($b64, $strict);
    }
}

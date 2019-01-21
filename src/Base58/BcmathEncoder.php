<?php

declare(strict_types = 1);

/*

Based on BaseConverter by Anthony Ferrara:
https://github.com/ircmaxell/SecurityLib/tree/master/lib/SecurityLib

Copyright (c) 2011 Anthony Ferrara
Copyright (c) 2017-2019 Mika Tuupola

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.

*/

namespace Tuupola\Base58;

use Tuupola\Base58;

class BcmathEncoder extends BaseEncoder
{
    /* http://codegolf.stackexchange.com/a/21672 */

    public function baseConvert(array $source, $sourceBase, $targetBase)
    {
        $result = [];
        while ($count = count($source)) {
            $quotient = [];
            $remainder = "0";
            $sourceBase = (string) $sourceBase;
            $targetBase = (string) $targetBase;
            for ($i = 0; $i !== $count; $i++) {
                $accumulator = bcadd((string) $source[$i], bcmul($remainder, $sourceBase));
                $digit = bcdiv($accumulator, $targetBase, 0);
                $remainder = bcmod($accumulator, $targetBase);
                if (count($quotient) || $digit) {
                    array_push($quotient, $digit);
                };
            }
            array_unshift($result, $remainder);
            $source = $quotient;
        }

        return $result;
    }
}

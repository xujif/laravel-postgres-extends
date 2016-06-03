<?php
namespace Xujif\LaravelPgSqlSchema\Eloquent;

class Utils
{
    /**
     * @param $value
     * @param string $cast
     * @return mixed
     */
    public static function pgArray2array($value, $cast = 'strval')
    {
        $value = trim($value);
        $len = strlen($value);
        $sign_mode = false;
        $stack = [];
        $item = '';
        $picking = false;
        for ($i = 0; $i < $len; $i++) {
            if ($sign_mode) {
                $sign_mode = false;
                $item .= $value[$i];
                continue;
            }
            switch ($value[$i]) {
                case '\\':
                    $sign_mode = true;
                    break;
                case '{':
                    $picking = false;
                    array_unshift($stack, []);
                    break;
                case '}':
                    if ($picking) {
                        $stack[0][] = call_user_func($cast, trim($item));
                        $item = '';
                    }
                    $picking = false;
                    $tmp = array_shift($stack);
                    $stack[0][] = $tmp;
                    break;
                case ',':
                    if ($picking) {
                        $stack[0][] = call_user_func($cast, trim($item));
                        $item = '';
                    }
                    $picking = false;
                    break;
                default:
                    if (!in_array($value[$i], ["\n", "\r", "\t", ' '])) {
                        $picking = true;
                    }
                    if ($picking) {
                        $item .= $value[$i];
                    }
            }
        }
        return $stack[0][0];
    }
    
    /**
     * @param $arr
     * @param int $depth
     * @return string
     */
    public static function array2pgArray($arr, $depth = 1)
    {
        if ($depth == 0) {
            $v = strval($arr);
            return preg_replace("/(?:[^\\\\])(\\{|\\})/i", "\\\\\${1}", $v);
        }
        $arr = array_map(function ($v) use ($depth) {
            return self::array2pgArray($v, $depth - 1);
        }, array_values($arr));
        return '{' . implode(',', $arr) . '}';
    }
}

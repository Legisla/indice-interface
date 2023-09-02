<?php

if (!function_exists('justLog')) {

    /**
     * @param mixed $message
     * @return void
     */
    function justLog(mixed $message): void
    {
        if (config('logging.show_log') == true) {
            if (!is_scalar($message)) {
                $message = var_export($message, true);
            }

            Log::channel('single')->info($message);
        }
    }
}

if (!function_exists('logImportation')) {

    /**
     * @param mixed $message
     * @return void
     */
    function logImportation(mixed $message): void
    {
        if (!is_scalar($message)) {
            $message = var_export($message, true);
        }

        Log::channel('importation')->info($message);
    }
}


if (!function_exists('mountErrorMessage')) {
    function mountErrorMessage(Throwable $t)
    {
        $trace = $t->getTrace();

        return get_class($t) . '! ' .
            $t->getFile() . ':' .
            $t->getLine() . '  = ' .
            $t->getMessage() . PHP_EOL .
            (isset($trace[1]['file']) ? 'trace1-> ' . $trace[1]['file'] . ':' . $trace[1]['line'] : '') . PHP_EOL .
            (isset($trace[2]['file']) ? 'trace2-> ' . $trace[2]['file'] . ':' . $trace[2]['line'] : '');
    }
}

if (!function_exists('compareStr')) {
    function compareStr($str1, $str2): bool
    {
        return removeSpecialChars(replaceAccents((strtolower($str1))))
            === removeSpecialChars(replaceAccents((strtolower($str2))));
    }
}

if (!function_exists('replaceAccents')) {
    function replaceAccents($string)
    {
        return str_replace(
            ['á', 'à', 'ã', 'â', 'ä', 'é', 'è', 'ê', 'ë', 'í', 'ì', 'î', 'ï', 'ó', 'ò', 'õ', 'ô', 'ö', 'ú', 'ù', 'û', 'ü', 'ç', 'Á', 'À', 'Ã', 'Â', 'Ä', 'É', 'È', 'Ê', 'Ë', 'Í', 'Ì', 'Î', 'Ï', 'Ó', 'Ò', 'Õ', 'Ô', 'Ö', 'Ú', 'Ù', 'Û', 'Ü', 'Ç'],
            ['a', 'a', 'a', 'a', 'a', 'e', 'e', 'e', 'e', 'i', 'i', 'i', 'i', 'o', 'o', 'o', 'o', 'o', 'u', 'u', 'u', 'u', 'c', 'A', 'A', 'A', 'A', 'A', 'E', 'E', 'E', 'E', 'I', 'I', 'I', 'I', 'O', 'O', 'O', 'O', 'O', 'U', 'U', 'U', 'U', 'C'],
            $string
        );
    }
}

if (!function_exists('removeSpecialChars')) {

    function removeSpecialChars($string)
    {
        return preg_replace('/[^A-Za-z0-9\- ]/', '', $string);
    }
}

if (!function_exists('strContainsSimplify')) {
    function strContainsSimplify(string $str1, string $str2): bool
    {
        return str_contains(
            removeSpecialChars(replaceAccents((strtolower($str1)))),
            removeSpecialChars(replaceAccents((strtolower($str2))))
        );
    }
}

if (!function_exists('show_memory')) {
    function show_memory($real_usage = false)
    {
        return number_format(
                (memory_get_usage($real_usage) / 1048576), 2, '.', ''
            )
            . '/' .
            number_format(
                (memory_get_peak_usage($real_usage) / 1048576), 2, '.', ''
            )
            . ' MB';
    }
}

use App\Models\Importation;

if (!function_exists('getLastImportationEnd')) {
    function getLastImportationEnd(): string
    {
        return Importation::getLastCompletedEnd() ?: '--';
    }
}

if (!function_exists('filterStrIntInput')) {
    function filterStrIntInput(\Illuminate\Support\Collection $obj, string $attribute, string $key = null): string
    {
        if ($key) {
            $value = $obj->get($key)?->{$attribute};
        } else {
            $value = $obj->get($attribute);
        }

        return is_string($value) || is_int($value) ? $value : '';
    }
}

if (!function_exists('calculateStars')) {
    function calculateStars($score): string
    {
        return floor(($score - 1) / 20) + 1;
    }
}


if (!function_exists('strContainsAtLeasOne')) {
    function strContainsAtLeasOne($str, $array): bool
    {
        foreach ($array as $item) {
            if (str_contains($str, $item)) {
                return true;
            }
        }

        return false;
    }
}


<?php
namespace App\Libs\Tool;

class CommonTool {
    public static function successResult($key = null, $value = null) {
        $base = array (
            'result' => 'success',
        );

        if (is_array($key)) {
            return array_merge($base, $key);
        } else if (is_scalar($key)) {
            $base[$key] = $value;
        }

        return $base;
    }

    public static function isSuccessRet($ret) {
        return $ret['result'] == 'success';
    }

    public static function isFailRet($ret) {
        return $ret['result'] == 'fail';
    }

    public static function failResult($reason) {
        return array (
            'result' => 'fail',
            'reason' => $reason
        );
    }

    public static function failCodeResult($code, $reason, $solution = '', $subErrors = '') {
        $result = array (
            'result' => 'fail',
            'code' => $code,
            'reason' => $reason
        );
        if (!empty($solution)) {
            $result['solution'] = $solution;
        }
        if (!empty($subErrors)) {
            $result['subErrors'] = $subErrors;
        }

        return $result;
    }
}

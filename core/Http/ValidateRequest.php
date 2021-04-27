<?php

namespace app\core\Http;

/**
 * Class ValidateRequest
 * @package app\core\Http
 *
 * This class is for validating
 * body data from request
 */
class ValidateRequest {
    protected const _KEYWORD_REQUIRED = 'required';

    public function validate(array $params): array {
        if (!count($params))
            Response::Instance()->errorMessage('validate params array must contain at least 1 argument');

        $data = Request::Instance()->body();

        foreach ($params as $key => $value) {
            if ($value === self::_KEYWORD_REQUIRED && !array_key_exists($key, $data)) {
                Response::Instance()->errorMessage("Requested body data must contain key named: {$key}");
            }
        }

        return $data;
    }
}
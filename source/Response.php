<?php
/*
 * Copyright 2015 Alexey Maslov <alexey.y.maslov@gmail.com>
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

namespace alxmsl\Telegram\Bot;

use Closure;

/**
 * API calls response class
 * @author alxmsl
 */
final class Response {
    /**
     * @var bool successful request or not
     */
    private $ok = false;

    /**
     * @var string human-readable description of the result
     */
    private $description = '';

    /**
     * @var null|mixed result instance
     */
    private $Result = null;

    /**
     * @var int error code
     */
    private $errorCode = 0;

    /**
     * @return boolean successful request or not
     */
    public function isOk() {
        return $this->ok;
    }

    /**
     * @return string human-readable description of the result
     */
    public function getDescription() {
        return $this->description;
    }

    /**
     * @return mixed|null result instance
     */
    public function getResult() {
        return $this->Result;
    }

    /**
     * @return int error code
     */
    public function getErrorCode() {
        return $this->errorCode;
    }

    /**
     * @param string $string response string
     * @param Closure $BuildStrategy build strategy for response result(s)
     * @return $this response instance
     */
    public static function initializeByString($string, $BuildStrategy = null) {
        $Object       = json_decode($string);
        $Response     = new self();
        $Response->ok = (bool) $Object->ok;
        if (isset($Object->description)) {
            $Response->description = (string) $Object->description;
        }
        if (isset($Object->error_code)) {
            $Response->errorCode = (int) $Object->error_code;
        }
        if (isset($Object->result)) {
            if (is_callable($BuildStrategy)) {
                if (is_array($Object->result)) {
                    $Response->Result = [];
                    foreach ($Object->result as $ResultItem) {
                        $Response->Result[] = $BuildStrategy($ResultItem);
                    }
                } else {
                    $Response->Result = $BuildStrategy($Object->result);
                }
            } else {
                $Response->Result = $Object->result;
            }
        }
        return $Response;
    }
}

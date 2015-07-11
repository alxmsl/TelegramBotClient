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
use stdClass;

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
     * @param stdClass $Object response data object
     * @return $this self instance
     */
    private function trySetDescription(stdClass $Object) {
        if (isset($Object->description)) {
            $this->description = (string) $Object->description;
        }
        return $this;
    }

    /**
     * @return string human-readable description of the result
     */
    public function getDescription() {
        return $this->description;
    }

    /**
     * @param stdClass $Object response data object
     * @param Closure|null $BuildStrategy build strategy for response result(s)
     * @return $this self instance
     */
    private function trySetResult(stdClass $Object, Closure $BuildStrategy = null) {
        if (isset($Object->result)) {
            if (is_callable($BuildStrategy)) {
                if (is_array($Object->result)) {
                    $this->Result = [];
                    foreach ($Object->result as $ResultItem) {
                        $this->Result[] = $BuildStrategy($ResultItem);
                    }
                } else {
                    $this->Result = $BuildStrategy($Object->result);
                }
            } else {
                $this->Result = $Object->result;
            }
        }
        return $this;
    }

    /**
     * @return mixed|null result instance
     */
    public function getResult() {
        return $this->Result;
    }

    /**
     * @param stdClass $Object response data object
     * @return $this self instance
     */
    private function trySetErrorCode(stdClass $Object) {
        if (isset($Object->error_code)) {
            $this->errorCode = (int) $Object->error_code;
        }
        return $this;
    }

    /**
     * @return int error code
     */
    public function getErrorCode() {
        return $this->errorCode;
    }

    /**
     * @param string $string response string
     * @param Closure|null $BuildStrategy build strategy for response result(s)
     * @return $this response instance
     */
    public static function initializeByString($string, Closure $BuildStrategy = null) {
        $Object       = json_decode($string);
        $Response     = new self();
        $Response->ok = (bool) $Object->ok;
        $Response->trySetDescription($Object)
            ->trySetErrorCode($Object)
            ->trySetResult($Object, $BuildStrategy);
        return $Response;
    }
}

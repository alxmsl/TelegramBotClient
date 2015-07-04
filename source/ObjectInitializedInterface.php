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

use stdClass;

/**
 * Interface for self-initialization objects by standard classes
 * @author alxmsl
 */
interface ObjectInitializedInterface {
    /**
     * Initialization method
     * @param stdClass $Object object for initialization
     * @return $this initialized object
     */
    public static function initializeByObject(stdClass $Object);
}

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

/**
 * Chat action constants
 * @author alxmsl
 */
final class Action {
    /**
     * Constants for chat actions
     */
    const TYPING          = 'typing',
          UPLOAD_PHOTO    = 'upload_photo',
          RECORD_VIDEO    = 'record_video',
          UPLOAD_VIDEO    = 'upload_video',
          RECORD_AUDIO    = 'record_audio',
          UPLOAD_AUDIO    = 'upload_audio',
          UPLOAD_DOCUMENT = 'upload_document',
          FIND_LOCATION   = 'find_location';
}

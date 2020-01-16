<?php

namespace InstagramAPI\Response;

use InstagramAPI\Response;

/**
 * CommentInfosResponse.
 *
 * @method Model\UnpredictableKeys\MediaUnpredictableContainer getCommentInfos()
 * @method mixed getMessage()
 * @method string getStatus()
 * @method Model\_Message[] get_Messages()
 * @method bool isCommentInfos()
 * @method bool isMessage()
 * @method bool isStatus()
 * @method bool is_Messages()
 * @method $this setCommentInfos(Model\UnpredictableKeys\MediaUnpredictableContainer $value)
 * @method $this setMessage(mixed $value)
 * @method $this setStatus(string $value)
 * @method $this set_Messages(Model\_Message[] $value)
 * @method $this unsetCommentInfos()
 * @method $this unsetMessage()
 * @method $this unsetStatus()
 * @method $this unset_Messages()
 */
class CommentInfosResponse extends Response
{
    const JSON_PROPERTY_MAP = [
        'comment_infos'    => 'Model\UnpredictableKeys\MediaUnpredictableContainer',
    ];
}

<?php

namespace ant\FotoBundle\Event;

/**
 * Declares all events thrown in the BadgeBundle
 */
final class AntFotoEvents
{
    /**
     * The POST_PUBLISH event occurs after an user have published a photo
     * The event is an instance of ant\FotoBundle\Event\FotoEvent
     *
     * @var string
     */
    const POST_PUBLISH = 'ant_foto.post_publish';

}

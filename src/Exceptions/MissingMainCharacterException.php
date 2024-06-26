<?php

namespace Goemktg\Seat\SeatDiscourse\Exceptions;

use Exception;
use Seat\Web\Models\Group;

class MissingMainCharacterException extends Exception
{
    /**
     * MissingMainCharacterException constructor.
     *
     * @param  \Seat\Web\Models\Group  $group
     */
    public function __construct(Group $group)
    {
        $message = sprintf('The group with ID %d does not have a main character set, ' .
            'or related character information is missing.', $group->id);
        parent::__construct($message, 0, null);
    }
}

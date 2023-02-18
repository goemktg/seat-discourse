<?php
/**
 * Created by PhpStorm.
 *  * User: Herpaderp Aldent
 * Date: 09.06.2018
 * Time: 10:48.
 */

namespace Goemktg\Seat\SeatDiscourse\Action\Discourse\Groups;

use Seat\Web\Models\Squads\Squad;
use Illuminate\Support\Str;

class Sync
{
    protected $attach;
    protected $detach;
    protected $get;

    public function __construct(Attach $attach, Detach $detach, Get $get)
    {
        $this->attach = $attach;
        $this->detach = $detach;
        $this->get = $get;
    }

    public function execute()
    {
        $squads = Squad::all();
        $groups = $this->get->execute();

        $feedback = collect();

        if($squads->map(function ($squad) {return $squad->name; })->diff($groups->map(function ($group) {return $group->name; }))->isNotEmpty())
        {
            $feedback->push($this->attach->execute($squads, $groups));
        }

        if($groups->map(function ($group) {return $group->name; })->diff($squads->map(function ($squad) {return str::studly($squad->name); }))->isNotEmpty()){
            $feedback->push($this->detach->execute($squads, $groups));
        }

        return $feedback;
    }
}

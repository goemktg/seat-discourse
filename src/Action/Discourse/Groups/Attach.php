<?php
/**
 * Created by PhpStorm.
 * User: fehu
 * Date: 05.06.18
 * Time: 18:01.
 */

namespace Goemktg\Seat\SeatDiscourse\Action\Discourse\Groups;

use Exception;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class Attach
{
    protected $create;

    public function __construct(Create $create)
    {
        $this->create = $create;
    }

    public function execute(Collection $squads, Collection $groups)
    {
        try{
            $feedback = collect();

            $groupnames_array = $groups->map(function ($group) {return $group->name; })->toArray();

            $squads->each(function ($squad) use ($feedback, $groupnames_array) {
                if(! in_array(str::studly($squad->name), $groupnames_array)){
                    $feedback->push($this->create->execute(str::studly($squad->name)));
                }
            });

            return $feedback;

        } catch (Exception $e){

            report($e);
            throw $e;
        }

    }
}

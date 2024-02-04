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

    public function execute(Collection $role_collection, Collection $group_collection)
    {
        try{
            $feedback = collect();

            $groupnames_array = $group_collection->map(function ($group) {return $group->name; })->toArray();

            $role_collection->each(function ($role) use ($feedback, $groupnames_array) {
                if(! in_array(str::studly($role->title), $groupnames_array)){
                    $feedback->push($this->create->execute(str::studly($role->title)));
                }
            });

            return $feedback;

        } catch (Exception $e){

            report($e);
            throw $e;
        }

    }
}

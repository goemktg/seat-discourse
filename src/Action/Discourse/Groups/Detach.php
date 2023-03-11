<?php
/**
 * Created by PhpStorm.
 * User: fehu
 * Date: 05.06.18
 * Time: 18:56.
 */

namespace Goemktg\Seat\SeatDiscourse\Action\Discourse\Groups;

use Exception;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class Detach
{
    protected $delete;

    public function __construct(Delete $delete)
    {
        $this->delete = $delete;
    }

    public function execute(Collection $role_collection, Collection $group_collection)
    {
        try{
            $rolenames_array = $role_collection->map(function ($role) {return str::studly($role->title); })->toArray();

            //Group minus squads, what is left should be deleted
            $groups_deleted = collect();
            $group_collection->each(function ($group) use ($rolenames_array, $groups_deleted) {
                if(! in_array($group->name, $rolenames_array)){
                    $groups_deleted->push($group->name);
                    $this->delete->execute($group->id);
                }
            });

            return 'Groups deleted ' . $groups_deleted;

        } catch (Exception $e){

            report($e);
            throw $e;
        }

    }
}

<?php
/**
 * Created by PhpStorm.
 *  * User: Herpaderp Aldent
 * Date: 05.04.2018
 * Time: 19:09.
 */

namespace Goemktg\Seat\SeatDiscourse\Commands;

use Goemktg\Seat\SeatDiscourse\Action\Discourse\Groups\Attach;
use Goemktg\Seat\SeatDiscourse\Action\Discourse\Groups\Create;
use Goemktg\Seat\SeatDiscourse\Action\Discourse\Groups\Detach;
use Goemktg\Seat\SeatDiscourse\Action\Discourse\Groups\Get;
use Goemktg\Seat\SeatDiscourse\Action\Discourse\Groups\Sync;
use Goemktg\Seat\SeatDiscourse\Action\Discourse\Users\ListUsers;
use Illuminate\Console\Command;
use Seat\Web\Models\Acl\Role;
use Seat\Web\Models\Group;

class SyncRolesWithDiscourse extends Command
{
    protected $signature = 'seat-discourse:roles:sync';
    protected $description = 'This command creates Discourse Groups according to the Roles in SeAT';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle(Get $get, Attach $attach, Detach $detach, Create $create, ListUsers $list_users, Sync $sync)
    {
        //return $get->execute();
        //$this->info($attach->execute(Role::all(),$get->execute()));
        //$this->info($detach->execute(Role::all(),$get->execute()));
        //$this->info($create->execute('test'));

        /*if(Group::find(3)->email)
        {
            $this->info($create->execute(Group::find(3)));
           //$this->info(studly_case(Group::find(2)->main_character->name));
        }*/

        $this->info($sync->execute());

        //return Role::all()->map(function($role) {return $role->title;})->diff($get->execute()->map( function ($group){return $group->name;}));

    }
}

<?php

namespace Goemktg\Seat\SeatDiscourse\Http\Controllers;

use Cviebrock\DiscoursePHP\SSOHelper;
use Goemktg\Seat\SeatDiscourse\Action\Discourse\Groups\Sync;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Seat\Web\Http\Controllers\Controller;
use Seat\Web\Models\Acl\Role;

//use Illumdinate\Contracts\Auth\Authenticatable as User;
//use Illuminate\Contracts\Config\Repository as Config;
//use Illuminate\Routing\Controller;
//use Illuminate\Support\Collection;
//use Seat\Web\Models\Acl\Role;

// temp
//use Illuminate\Support\Str;

/**
 * Class SsoController.
 *
 * Controller to process the Discourse SSO request.  There is a good bit of logic in here that almost feels like too
 * much for a controller, but given that this is the only thing that this controller is doing, I am not going to break
 * it out into some service class.
 *
 * @package Spinen\Discourse
 */
class SsoController extends Controller
{
    /**
     * Package configuration.
     *
     * @var Collection
     */
    //protected $config;

    /**
     * SSOHelper Instance.
     *
     * @var SSOHelper
     */
    protected $sso;

    /**
     * Authenticated user.
     *
     * @var User
     */
    //protected $user;

    /**
     * SsoController constructor.
     *
     * @param  SSOHelper  $sso
     */
    public function __construct(SSOHelper $sso)
    {
        $this->sso = $sso->setSecret(config('seatdiscourse.config.connect_secret'));
    }

    public function redirect()
    {
        if (! auth()->user()->email) {
            return redirect()->route('seatcore::profile.view')->with('error', 'You must enter an email address to use the forum.');
        }

        return redirect()->away(config('seatdiscourse.config.url'));
    }

    /**
     * Build out the extra parameters to send to Discourse.
     *
     * @return array
     */
    protected function buildExtraParameters()
    {
        return [
            // Groups to make sure that the user is part of in a comma-separated string
            // NOTE: Groups cannot have spaces in their names & must already exist in Discourse
            'add_groups' => $this->user->roles->map(function ($role) {
                return str::studly($role->title);
            })->implode(','),

            // Boolean for user a Discourse admin, leave null to ignore
            //'admin' => null,

            // Full path to user's avatar image
            'avatar_url' => 'http://image.eveonline.com/Character/' . $this->user->main_character_id . '_128.jpg',

            // The avatar is cached, so this triggers an update
            'avatar_force_update' => true,

            // Content of the user's bio
            //'bio' => null,

            // Boolean for user a Discourse admin, leave null to ignore
            //'moderator' => null,

            // Full name on Discourse if the user is new or
            // if SiteSetting.sso_overrides_name is set
            'name' => $this->user->name,

            // Groups to make sure that the user is *NOT* part of in a comma-separated string
            // NOTE: Groups cannot have spaces in their names & must already exist in Discourse
            // There is not a way to specify the exact list of groups that a user is in, so
            // you may want to send the inverse of the 'add_groups'
            'remove_groups' => Role::all()->diff($this->user->roles)->map(function ($role) {
                return str::studly($role->title);
            })->implode(','),

            // If the email has not been verified, set this to true
            'require_activation' => false,

            // username on Discourse if the user is new or
            // if SiteSetting.sso_overrides_username is set
            'username' => $this->user->name,
        ];
    }

    /**
     * Make boolean's into string.
     *
     * The Discourse SSO API does not accept 0 or 1 for false or true.  You must send
     * "false" or "true", so convert any boolean property to the string version.
     *
     * @param  $property
     * @return string
     */
    public function castBooleansToString($property)
    {
        if (! is_bool($property)) {
            return $property;
        }

        return ($property) ? 'true' : 'false';
    }

    /**
     * Process the SSO login request from Discourse.
     *
     * @param  Request  $request
     * @param  \Goemktg\Seat\SeatDiscourse\Action\Discourse\Groups\Sync  $sync
     * @return mixed
     *
     * @throws \Cviebrock\DiscoursePHP\Exception\PayloadException
     */
    public function login(Request $request, Sync $sync)
    {
        if(! auth()->user()->email){
            return redirect()->route('seatcore::profile.view')->with('error', 'You must enter an email address to use the forum.');
        }

        //ToDo: Refactoring sync by replacing it with model events

        $sync->execute();

        /* TODO : fix this ( with setting - strict token check )
        foreach ($request->user()->all_characters() as $char_info) {
            dd($char_info->refresh_token());
        }

        foreach ($this->user->group->users as $user){
            if (is_null($user->refresh_token))
                return redirect()->route('profile.view')->with('error', 'One of your characters is missing its refresh token. Please login with him again');
        }
        */

        $this->user = $request->user();

        if (! $this->sso->validatePayload($payload = $request->get('sso'), $request->get('sig'))) {
            abort(403); //Forbidden
        }

        $query = $this->sso->getSignInString(
            $this->sso->getNonce($payload),
            $this->user->main_character_id,
            $this->user->email,
            $this->buildExtraParameters()
        );

        return redirect(str::finish(config('seatdiscourse.config.url'), '/') . 'session/sso_login?' . $query);
    }

    /**
     * Check to see if property is null.
     *
     * @param  string  $property
     * @return bool
     */
    public function nullProperty($property)
    {
        return is_null($property);
    }

    /**
     * Get the property from the user.
     *
     * If a string is passed in, then get it from the user object, otherwise, return what was given
     *
     * @param  string  $property
     * @return mixed
     */
    public function parseUserValue($property)
    {
        if (! is_string($property)) {
            return $property;
        }

        return $this->user->{$property};
    }
}

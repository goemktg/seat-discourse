<?php
/**
 * Created by PhpStorm.
 * User: fehu
 * Date: 07.06.18
 * Time: 09:04.
 */

namespace Goemktg\Seat\SeatDiscourse\Action\Discourse\Users;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class ListUsers
{
// {{base_url}}/admin/users/list/active.json?api_key={{api_key}}&api_username={{api_username}}&order=topics_entered
// show_emails=true

    public function execute()
    {
        $client = new Client();
        try {
            $response = $client->request('GET', config('seatdiscourse.config.url') . '/admin/users/list/active.json', [
                'query' => [
                    'order' => 'topics_entered',
                    'show_emails' => 'true',
                ],
                'headers' => [
                    'api-key' => config('seatdiscourse.config.api_key'),
                    'api-username' => config('seatdiscourse.config.api_username'),
                ],
            ]);

            return collect(json_decode($response->getBody()));
        } catch (GuzzleException $e) {
            return $e;
        }

    }
}

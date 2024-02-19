<?php
/**
 * Created by PhpStorm.
 * User: felix
 * Date: 21.09.2018
 * Time: 21:51.
 */

namespace Goemktg\Seat\SeatDiscourse\Action\Discourse\Users;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class GetUserByCharacterId
{
    public function execute(int $id)
    {
        $client = new Client();
        try {
            $response = $client->request('GET', config('seatdiscourse.config.url') . '/users/by-external/' . $id . '.json', [
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

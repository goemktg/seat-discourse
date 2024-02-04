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
            $response = $client->request('GET', getenv('DISCOURSE_URL') . '/users/by-external/' . $id . '.json', [
                'headers' => [
                    'api-key' => getenv('DISCOURSE_API_KEY'),
                    'api-username' => getenv('DISCOURSE_API_USERNAME'),
                ],
            ]);

            return collect(json_decode($response->getBody()));
        } catch (GuzzleException $e) {
            return $e;
        }
    }
}

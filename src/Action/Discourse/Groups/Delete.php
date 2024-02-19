<?php
/**
 * Created by PhpStorm.
 * User: fehu
 * Date: 05.06.18
 * Time: 18:44.
 */

namespace Goemktg\Seat\SeatDiscourse\Action\Discourse\Groups;

use Goemktg\Seat\SeatDiscourse\Exceptions\DiscourseGuzzleException;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class Delete
{
    /**
     * @param  int  $group_id
     * @return string
     */
    public function execute(int $group_id)
    {

        $client = new Client();
        try {
            $response = $client->request('DELETE', config('seatdiscourse.config.url') . '/admin/groups/' . $group_id . '.json', [
                'headers' => [
                    'api-key' => config('seatdiscourse.config.api_key'),
                    'api-username' => config('seatdiscourse.config.api_username'),
                ],

                'decode_content' => false,
            ]);

            if (200 === $response->getStatusCode()) {

                return 'success';

            }

            abort(500, 'Something went wrong at deleting group');
        } catch (GuzzleException $e) {

            throw new DiscourseGuzzleException($e->getMessage(), $e->getCode());
        }

    }
}

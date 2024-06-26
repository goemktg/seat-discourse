<?php
/**
 * Created by PhpStorm.
 * User: fehu
 * Date: 05.06.18
 * Time: 16:01.
 */

namespace Goemktg\Seat\SeatDiscourse\Action\Discourse\Groups;

use Goemktg\Seat\SeatDiscourse\Exceptions\DiscourseGuzzleException;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class Create
{
    /**
     * @param  string  $groupname
     * @return string
     *
     * @throws \Goemktg\Seat\SeatDiscourse\Exceptions\DiscourseGuzzleException
     */
    public function execute(string $groupname): string
    {
        $client = new Client();
        try {
            $response = $client->request('POST', config('seatdiscourse.config.url') . '/admin/groups', [
                'form_params' => [
                    'group[name]' => $groupname,
                ],
                'headers' => [
                    'api-key' => config('seatdiscourse.config.api_key'),
                    'api-username' => config('seatdiscourse.config.api_username'),
                ],

                'decode_content' => false,
            ]);

            if (200 === $response->getStatusCode()) {

                return 'Created Group: ' . $groupname;

            }

            abort(500, 'Something went wrong at /admin/groups');
        } catch (GuzzleException $e) {

            throw new DiscourseGuzzleException($e->getMessage(), $e->getCode());
        }

    }
}

<?php
/**
 * Created by PhpStorm.
 * User: fehu
 * Date: 05.06.18
 * Time: 13:13.
 */

namespace Goemktg\Seat\SeatDiscourse\Action\Discourse\Groups;

use Exception;
use Goemktg\Seat\SeatDiscourse\Exceptions\DiscourseGuzzleException;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Collection;

class Get
{
    /**
     * @return \Illuminate\Support\Collection
     *
     * @throws \Goemktg\Seat\SeatDiscourse\Exceptions\DiscourseGuzzleException
     */
    public function execute(): Collection
    {
        $client = new Client();
        try {
            $response = $client->request('GET', config('seatdiscourse.config.url') . '/groups/search.json', [
                'headers' => [
                    'api-key' => config('seatdiscourse.config.api_key'),
                    'api-username' => config('seatdiscourse.config.api_username'),
                ],
                //'debug' => true,
                'decode_content' => false,
            ]);

            if(! $response->getStatusCode() === 200)
                throw new Exception($response->getMessage(), $response->getStatusCode());

            $body = collect(json_decode($response->getBody()))->reject(function ($item) {
                return $item->automatic;
            });

            return $body;
        } catch (GuzzleException $e) {

            throw new DiscourseGuzzleException($e->getMessage(), $e->getCode());
        }

    }
}

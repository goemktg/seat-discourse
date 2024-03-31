<?php
/**
 * Created by PhpStorm.
 *  * User: Herpaderp Aldent
 * Date: 09.06.2018
 * Time: 18:56.
 */

return [
    'seat-discorse' => [
        'name' => 'SeAT Discourse',
        'icon' => 'fas fa-comments',
        'route_segment' => 'sso',
        'entries' => [
            [
                'name' => 'Forum',
                'icon' => 'fas fa-comment',
                'route' => 'sso.forum',
            ],
            [
                'name' => 'About',
                'icon' => 'fas fa-info-circle',
                'route' => 'seatdiscourse.about',
            ],
        ],

    ],
];

<?php

return [
    'status' => [
        'all' => 0,
        'invisible'=> 1,
        'visible' => 2,
        'deleted' => 3
    ],
    'order_delivery' => [
        'all' => 0,
        'non_delivery' => 1,
        'delivery' => 2
    ],
    'order_status' => [
        'all' => 0,
        'unpaid' => 1,
        'paid' => 2,
    ],
    'order_confirm' => [
        'all' => 0,
        'wait' => 1,
        'process' => 2,
        'complete' => 3,
    ],
    'order_detail_status' => [
        'all' => 0,
        'wait' => 1,
        'process' => 2,
        'complete' => 3,
        'done' => 4,
    ],
    'permission' => [
        'all'=> 0,
        'admin' => 1,
        'staff' => 2,
        'chef' => 3,
    ],
    'desk_status' => [
        'all'=> 0,
        'avaliable' => 1,
        'unavaliable' => 2,
        'booking' => 3,
    ],
    'customer_id' => [
        'on_desk' => 1,
        'on_delivery' => 2,
    ],
];
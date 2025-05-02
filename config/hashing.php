<?php

return [

    'driver' => 'argon',    //use the Argon algorithm for hashing (instead of the default bcrypt)

    //just in case want to switch back to Bcrypt
    //not active unless change the driver to 'bcrypt'.
    'bcrypt' => [
        'rounds' => env('BCRYPT_ROUNDS', 10),   
    ],

    'argon' => [
        'memory'  => 65536,
        'threads' => 2,
        'time'    => 4,     //4 times hashing
        'type'    => PASSWORD_ARGON2ID,
    ],

];

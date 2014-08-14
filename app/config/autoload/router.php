<?php

return array(
    'router' => array(
        'redirect' => array(
            '/admin/cities/' => 'Admin\\CitiesController',
            '/admin/regions/' => 'Admin\\RegionsController',
            '/admin/users/' => 'Admin\\UsersController',
            /*You can even do something like that */
            // '/people' => 'Admin\\UsersController',
            // 'staff' => 'MapController',
        )
    )
);
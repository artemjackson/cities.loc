<?php

return array(
    'router' => array(
        'redirect' => array(
            '/admin/cities' => 'admin/CitiesController',
            '/admin/regions' => 'admin/RegionsController',
            '/admin/users' => 'admin/UsersController',
            /*You can even do something like this */
            // '/people' => 'admin/UsersController',
            // 'staff' => 'MapController',
        )
    )
);
<?php
    /**
     * Created by DeveloperPro ®.
     * User: Gilberto Guerrero Quinayas
     * Date: 22/09/2018
     * Time: 4:27 PM
     */
    
    use \Psr\Http\Message\ServerRequestInterface as Request;
    use \Psr\Http\Message\ResponseInterface as Response;
    
    $app->group('/api-configuration/', function () {
        $this->group('countries/', function () {
            $this->post('new', function (Request $request, Response $response, array $args) {
            });
        });
    });
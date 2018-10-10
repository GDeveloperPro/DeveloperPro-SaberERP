<?php
    /**
     * Created by DeveloperPro ®.
     * User: Gilberto Guerrero Quinayas
     * Date: 21/09/2018
     * Time: 4:15 PM
     */
    
    use \Psr\Http\Message\ServerRequestInterface as Request;
    use \Psr\Http\Message\ResponseInterface as Response;
    
    $app->group('/api-lms/', function () {
        $this->group('answers/', function () {
            $this->post('new', function (Request $request, Response $response, array $args) {
            });
        });
    });
<?php
    /**
     * Created by DeveloperPro ®.
     * User: Gilberto Guerrero Quinayas
     * Date: 21/09/2018
     * Time: 3:20 PM
     */
    
    use \Psr\Http\Message\ServerRequestInterface as Request;
    use \Psr\Http\Message\ResponseInterface as Response;
    
    $app->group('/api-security/', function () {
        $this->group('roles/', function () {
            $this->post('new', function (Request $request, Response $response, array $args) {
            });
        });
    });
<?php
    /**
     * Created by DeveloperPro ®.
     * User: Gilberto Guerrero Quinayas
     * Date: 21/09/2018
     * Time: 3:38 PM
     */
    
    use \Psr\Http\Message\ServerRequestInterface as Request;
    use \Psr\Http\Message\ResponseInterface as Response;
    
    $app->group('/api-erp/', function () {
        $this->group('debitNotes/', function () {
            $this->post('new', function (Request $request, Response $response, array $args) {
            });
        });
    });
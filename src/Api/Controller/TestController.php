<?php

declare(strict_types=1);

namespace App\Api\Controller;

use App\Api\Utils\AuthService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route(path="/test")
 */
class TestController
{
    /**
     * @Route(path="/", methods={"GET"})
     */
    public function index(Request $request, AuthService $authService)
    {
        $authMetaData = $request->headers->get('Authorization', '');

        if($authMetaData !=='' && $authService->checkCredentials($authMetaData)) {
            return new Response(
                json_encode([
                    'message'=>'Ok, method logic result is here',
                ]),
                Response::HTTP_OK,
                [
                    'Content-type'=>'application/json'
                ]
            );
        }

        return new Response(
            json_encode([
                'message'=>'Not Authorized',
            ]),
            Response::HTTP_UNAUTHORIZED,
            [
                'www-Authenticate' => 'Basic realm="Access to the staging site", charset="UTF-8"',
                'Content-type'=>'application/json'
            ]
        );
    }

    /**
     * @Route(path="/users", methods={"GET"})
     */
    public function users()
    {
        $token = $_SERVER['HTTP_AUTHORIZATION'];
        $tokenParts = explode(".", str_replace("BEARER ", "", $token));
        $tokenHeader = base64_decode($tokenParts[0]);
        $tokenPayload = base64_decode($tokenParts[1]);
        $jwtHeader = json_decode($tokenHeader);
        $jwtPayload = json_decode($tokenPayload);

        return new Response(
            json_encode(
                [
                    "username" => $jwtPayload->username,
                    "iat" => $jwtPayload->iat,
                    "exp" => $jwtPayload->exp,
                    "roles" => $jwtPayload->roles
                ]
            ),
            Response::HTTP_OK,
            [
                'Content-type'=> 'application/json'
            ]
        );
    }
}
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
        return new Response(
            content: json_encode(
                [
                    new class ('Innokentiy', 21) {
                        public $name;
                        public $age;

                        public function __construct($name, $age)
                        {
                            $this->name = $name;
                            $this->age = $age;
                        }
                    },

                    new class ('Fedor', 17) {
                        public $name;
                        public $age;

                        public function __construct($name, $age)
                        {
                            $this->name = $name;
                            $this->age = $age;
                        }
                    }
                ]
            ),
            status: Response::HTTP_OK,
            headers: [
                'Content-type'=> 'application/json'
            ]
        );
    }

    /**
     * @Route(path="/login", methods={"GET"})
     */
    public function test()
    {
        return new Response(
            content: json_encode(
            [
                new class ('test', 10) {
                    public $name;
                    public $age;

                    public function __construct($name, $age)
                    {
                        $this->name = $name;
                        $this->age = $age;
                    }
                },

                new class ('rest', 90) {
                    public $name;
                    public $age;

                    public function __construct($name, $age)
                    {
                        $this->name = $name;
                        $this->age = $age;
                    }
                }
            ]
        ),
            status: Response::HTTP_OK,
            headers: [
                'Content-type'=> 'application/json'
            ]
        );
    }
}
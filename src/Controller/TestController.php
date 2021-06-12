<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/test")
 */
class TestController
{
    /**
     * @Route(path="/", methods={"GET"})
     */
    public function index()
    {
        return new Response(
            json_encode(
                [
                    'some-value'=> 123,
                    'some-value-string'=> 'some string'
                ]
            ),
            Response::HTTP_OK,
            [
                'Content-type'=> 'application/json'
            ]
        );
    }

    /**
     * @Route(path="/users", methods={"GET"})
     */
    public function users()
    {
        return new Response(
            json_encode(
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
            Response::HTTP_OK,
            [
                'Content-type'=> 'application/json'
            ]
        );
    }

}
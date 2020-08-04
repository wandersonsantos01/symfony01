<?php


namespace App\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class OlaMundoController
{

    /**
     * @Route("/ola")
     */
    public function OlaMundoAction(Request $request) : Response
    {
        $pathInfo = $request->getPathInfo();
        $param = $request->query->get("param");
        return new JsonResponse(["success" => true, "mensagem" => "Olá mundo", "pathInfo" => $pathInfo, "param" => $param]);
    }

}
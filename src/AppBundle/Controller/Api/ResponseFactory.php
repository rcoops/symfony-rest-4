<?php
/**
 * Created by PhpStorm.
 * User: rick
 * Date: 20/03/18
 * Time: 14:30
 */

namespace AppBundle\Controller\Api;


use AppBundle\Api\ApiProblem;
use AppBundle\Api\ApiProblemException;
use Symfony\Component\HttpFoundation\JsonResponse;

class ResponseFactory
{

    /**
     * @param ApiProblem $apiProblem
     * @return JsonResponse
     */
    public function createResponse(ApiProblem $apiProblem)
    {
        $data = $apiProblem->toArray();
        // making type a URL, to a temporarily fake page
        if ($data['type'] != 'about:blank') {
            $data['type'] = 'http://localhost:8000/docs/errors#'.$data['type'];
        }
        $response = new JsonResponse(
            $data,
            $apiProblem->getStatusCode()
        );
        $response->headers->set('Content-Type', 'application/problem+json');
        return $response;
    }

}
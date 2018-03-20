<?php
/**
 * Created by PhpStorm.
 * User: rick
 * Date: 20/03/18
 * Time: 13:37
 */

namespace AppBundle\Controller\Api;


use AppBundle\Controller\BaseController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\BadCredentialsException;

class TokenController extends BaseController
{

    /**
     * @Route("/api/tokens")
     * @Method("POST")
     * @param Request $request
     * @return JsonResponse
     * @throws \Lexik\Bundle\JWTAuthenticationBundle\Exception\JWTEncodeFailureException
     */
    public function newTokenAction(Request $request)
    {
        $user = $this->getDoctrine()->getRepository('AppBundle:User')
            ->findOneBy(['username' => $request->getUser()]);

        if (!$user) {
            throw $this->createNotFoundException('No user');
        }

        $isValid = $this->get('security.password_encoder')
            ->isPasswordValid($user, $request->getPassword());

        if (!$isValid) {
            throw new BadCredentialsException();
        }

        $token = $this->get('lexik_jwt_authentication.encoder')
            ->encode(['username' => $user->getUsername()]);

        return new JsonResponse(['token' => $token], 201);
    }

}
<?php
/**
 * Created by PhpStorm.
 * User: rick
 * Date: 20/03/18
 * Time: 13:34
 */

namespace Tests\AppBundle\Controller\Api;


use AppBundle\Test\ApiTestCase;

class TokenControllerTest extends ApiTestCase
{

    /**
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \Exception
     */
    public function testPOSTCreateToken()
    {
        $this->createUser('weaverryan', 'I<3Pizza');

        $response = $this->client->post('/api/tokens', [
            'auth' => ['weaverryan', 'I<3Pizza'],
        ]);

        $this->assertEquals(201, $response->getStatusCode());
        $this->asserter()->assertResponsePropertyExists($response, 'token');
    }

    /**
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \Exception
     */
    public function testPOSTCreateTokenInvalidCredentials()
    {
        $this->createUser('weaverryan', 'I<3Pizza');

        $response = $this->client->post('/api/tokens', [
            'auth' => ['weaverryan', 'IH8Pizza'],
        ]);

        $this->assertEquals(401, $response->getStatusCode());
    }

}
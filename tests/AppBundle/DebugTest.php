<?php

namespace Tests\AppBundle;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DebugTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/debug');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertContains('foo', $crawler->filter('#foo')->text());
    }
}

<?php

namespace MovingImage\Bundle\VMProApiBundle\Tests\DependencyInjection\VMProApiExtensionTest;

use GuzzleHttp\ClientInterface;
use MovingImage\Bundle\VMProApiBundle\DependencyInjection\VMProApiExtension;
use MovingImage\Bundle\VMProApiBundle\Tests\DependencyInjection\AbstractTestCase;
use MovingImage\Client\VMPro\ApiClient\Guzzle5ApiClient;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * Class Guzzle5Test.
 *
 * @author Ruben Knol <ruben.knol@movingimage.com>
 */
class Guzzle5Test extends AbstractTestCase
{
    /**
     * Skip this test if Guzzle ^6.0 is installed.
     */
    public function setUp()
    {
        if (version_compare(ClientInterface::VERSION, '6.0', '>=')) {
            $this->markTestSkipped('Skipping test when Guzzle ~6.0 is installed');
        }
    }

    /**
     * Assert whether when Guzzle ^5.0 is installed, the right instance
     * of the API client is placed in the dependency injection container.
     */
    public function testHasGuzzle5Client()
    {
        $container = new ContainerBuilder();
        $loader = new VMProApiExtension();
        $config = $this->getFullConfig();

        $loader->load($config, $container);

        $this->assertInstanceOf(Guzzle5ApiClient::class, $container->get('vmpro_api.client'));
    }
}

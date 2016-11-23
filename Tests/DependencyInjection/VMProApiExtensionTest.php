<?php

namespace MovingImage\Bundle\VMProApiBundle\Tests\DependencyInjection;

use GuzzleHttp\ClientInterface;
use MovingImage\Bundle\VMProApiBundle\DependencyInjection\VMProApiExtension;
use MovingImage\Client\VMPro\ApiClient\Guzzle5ApiClient;
use MovingImage\Client\VMPro\ApiClient\Guzzle6ApiClient;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Yaml\Parser;

class VMProApiExtensionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Get empty configuration set.
     *
     * @return array
     */
    protected function getEmptyConfig()
    {
        $yaml = <<<'EOF'
vm_pro_api:
    credentials:
        username:  ~
        password:  ~
EOF;
        $parser = new Parser();

        return $parser->parse($yaml);
    }

    /**
     * Get empty configuration set.
     *
     * @return array
     */
    protected function getFullConfig()
    {
        $yaml = <<<'EOF'
vm_pro_api:
    base_url:      http://google.com/
    default_vm_id: 5
    credentials:
        username:  test@test.com
        password:  test_password
EOF;
        $parser = new Parser();

        return $parser->parse($yaml);
    }

    /**
     * Assert whether an exception is thrown when required configuration
     * key 'vm_pro_api.credentials' is missing.
     *
     * @expectedException \Symfony\Component\Config\Definition\Exception\InvalidConfigurationException
     */
    public function testConfigurationLoadThrowsExceptionUnlessCredentials()
    {
        $loader = new VMProApiExtension();
        $config = $this->getEmptyConfig();

        unset($config['vm_pro_api']['credentials']);
        $loader->load($config, new ContainerBuilder());
    }

    /**
     * Assert whether an exception is thrown when required configuration
     * key 'vm_pro_api.credentials.username' is missing.
     *
     * @expectedException \Symfony\Component\Config\Definition\Exception\InvalidConfigurationException
     */
    public function testConfigurationLoadThrowsExceptionUnlessUsername()
    {
        $loader = new VMProApiExtension();
        $config = $this->getEmptyConfig();

        unset($config['vm_pro_api']['credentials']['username']);
        $loader->load($config, new ContainerBuilder());
    }

    /**
     * Assert whether an exception is thrown when required configuration
     * key 'vm_pro_api.credentials.password' is missing.
     *
     * @expectedException \Symfony\Component\Config\Definition\Exception\InvalidConfigurationException
     */
    public function testConfigurationLoadThrowsExceptionUnlessPassword()
    {
        $loader = new VMProApiExtension();
        $config = $this->getEmptyConfig();

        unset($config['vm_pro_api']['credentials']['password']);
        $loader->load($config, new ContainerBuilder());
    }

    /**
     * Assert whether the configuration keys and values are successfully
     * written as parameters.
     */
    public function testParametersForFullConfig()
    {
        $container = new ContainerBuilder();
        $loader = new VMProApiExtension();
        $config = $this->getFullConfig();

        $loader->load($config, $container);

        $this->assertEquals('http://google.com/', $container->getParameter('vm_pro_api_base_url'));
        $this->assertEquals(5, $container->getParameter('vm_pro_api_default_vm_id'));
        $this->assertEquals('test@test.com', $container->getParameter('vm_pro_api_credentials_username'));
        $this->assertEquals('test_password', $container->getParameter('vm_pro_api_credentials_password'));
    }

    /**
     * Assert whether the configuration keys and values are successfully
     * written as parameters with the right default values.
     */
    public function testDefaultParameters()
    {
        $container = new ContainerBuilder();
        $loader = new VMProApiExtension();
        $config = $this->getEmptyConfig();

        $loader->load($config, $container);

        $this->assertEquals('https://api.video-cdn.net/v1/vms/', $container->getParameter('vm_pro_api_base_url'));
        $this->assertEquals(0, $container->getParameter('vm_pro_api_default_vm_id'));
    }

    /**
     * Assert whether when Guzzle ^5.0 is installed, the right instance
     * of the API client is placed in the dependency injection container.
     */
    public function testHasGuzzle5Client()
    {
        if (version_compare(ClientInterface::VERSION, '6.0', '>=')) {
            $this->markTestSkipped('Skipping test when Guzzle ~6.0 is installed');
        }

        $container = new ContainerBuilder();
        $loader = new VMProApiExtension();
        $config = $this->getFullConfig();

        $loader->load($config, $container);

        $this->assertInstanceOf(Guzzle5ApiClient::class, $container->get('vmpro_api.client'));
    }

    /**
     * Assert whether when Guzzle ^6.0 is installed, the right instance
     * of the API client is placed in the dependency injection container.
     */
    public function testHasGuzzle6Client()
    {
        if (version_compare(ClientInterface::VERSION, '6.0', '<')) {
            $this->markTestSkipped('Skipping test when Guzzle ~5.0 is installed');
        }

        $container = new ContainerBuilder();
        $loader = new VMProApiExtension();
        $config = $this->getFullConfig();

        $loader->load($config, $container);

        $this->assertInstanceOf(Guzzle6ApiClient::class, $container->get('vmpro_api.client'));
    }
}

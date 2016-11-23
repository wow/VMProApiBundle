<?php

namespace MovingImage\Bundle\VMProApiBundle\Tests\DependencyInjection;

use Symfony\Component\Yaml\Parser;

abstract class AbstractTestCase extends \PHPUnit_Framework_TestCase
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
}

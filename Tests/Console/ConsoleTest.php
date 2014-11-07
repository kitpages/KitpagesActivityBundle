<?php
namespace Kitpages\ActivityBundle\Tests\Console;

use Kitpages\ActivityBundle\Tests\CommandTestCase;

class ConsoleTest
    extends CommandTestCase
{
    public function testRunCommandSimple()
    {
        $client = self::createClient();
        // this test is used to check if configurations are ok, even in service.xml
        $output = $this->runCommand($client, "cache:clear --no-warmup --env=test");
        $this->assertContains('Clearing the cache for the test', $output);
    }
}
<?php

namespace Tests\Unit\User\Auth\Social;

use App\Helpers\Factory\Auth\Drivers\OkSocializeDriver;
use App\Helpers\Factory\Auth\Drivers\VkSocializeDriver;
use App\Helpers\Factory\Auth\SocialDriverFactory;
use Tests\TestCase;

class FactoryTest extends TestCase
{
    /** @var SocialDriverFactory */
    private $factory;

    public function setUp(): void
    {
        parent::setUp();

        $this->factory = new SocialDriverFactory();
    }

    public function testOkFactoryDriver()
    {
        $inc = $this->factory->getInstance('odnoklassniki');
        $this->assertTrue($inc instanceof OkSocializeDriver);

        $inc = $this->factory->getInstance('oDnoKlassniki');
        $this->assertTrue($inc instanceof OkSocializeDriver);
    }

    public function testVkFactoryDriver()
    {
        $inc = $this->factory->getInstance('VKONTAKTE');
        $this->assertTrue($inc instanceof VkSocializeDriver);

        $inc = $this->factory->getInstance('vkontakte');
        $this->assertTrue($inc instanceof VkSocializeDriver);
    }

    public function testUndefinedFactoryDriver()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('The driver is undefined.');

        $this->factory->getInstance('undefined');
    }
}

<?php

namespace Tests\Unit\User\Auth\Social;

use App\Helpers\Factory\Auth\Drivers\OkSocializeDriver;
use App\Helpers\Factory\Auth\SocialDriverFactory;
use Tests\TestCase;

class VkTest extends TestCase
{
    /** @var SocialDriverFactory */
    private $factory;

    /** @var OkSocializeDriver */
    private $inc;

    /** @var array */
    private $data;

    public function setUp(): void
    {
        parent::setUp();

        $this->factory = new SocialDriverFactory();
        $this->data = [
            'first_name' => 'Alexander',
            'last_name' => 'Fomenko',
            'photo' => 'https://sun9-45.userapi.com/c855416/v855416109/1a191a/40DKta3fpTg.jpg?ava=1',
        ];
        $this->inc = $this->factory->getInstance('vkontakte');
    }

    public function testOkDefaultParams()
    {
        $this->assertEquals($this->inc->getScopes(), ['email']);
        $this->assertEquals($this->inc->getFirstName(), null);
        $this->assertEquals($this->inc->getLastName(), null);
        $this->assertEquals($this->inc->getEmail(), null);
    }

    public function testOkSuccessResponse()
    {
        $inc = $this->inc->loadResponse($this->data);

        $this->assertEquals($inc->getScopes(), ['email']);
        $this->assertEquals('Alexander', $inc->getFirstName());
        $this->assertEquals('Fomenko', $inc->getLastName());
        $this->assertEquals(null, $inc->getEmail());
        $this->assertEquals('https://sun9-45.userapi.com/c855416/v855416109/1a191a/40DKta3fpTg.jpg?ava=1', $inc->getAvatar());
    }
}

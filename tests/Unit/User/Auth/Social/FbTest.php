<?php

namespace Tests\Unit\User\Auth\Social;

use App\Helpers\Factory\Auth\Drivers\FacebookSocializeDriver;
use App\Helpers\Factory\Auth\SocialDriverFactory;
use Tests\TestCase;

class FbTest extends TestCase
{
    /** @var SocialDriverFactory */
    private $factory;

    /** @var FacebookSocializeDriver */
    private $inc;

    /** @var array */
    private $data;

    public function setUp(): void
    {
        parent::setUp();

        $this->factory = new SocialDriverFactory();
        $this->data = [
            'id' => 100500,
            'name' => 'Fomenko Alexander',
        ];
        $this->inc = $this->factory->getInstance('facebook');
    }

    public function testFBSuccessResponse()
    {
        $inc = $this->inc->loadResponse($this->data);

        $avatar = "https://graph.facebook.com/{$this->data['id']}/picture?type=".FacebookSocializeDriver::PHOTO_TYPE;

        $this->assertEquals($inc->getScopes(), ['email']);
        $this->assertEquals('Alexander', $inc->getFirstName());
        $this->assertEquals('Fomenko', $inc->getLastName());
        $this->assertEquals(null, $inc->getEmail());
        $this->assertEquals($avatar, $inc->getAvatar());
    }
}

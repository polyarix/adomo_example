<?php

namespace Tests\Unit\User\Auth\Social;

use App\Helpers\Factory\Auth\Drivers\OkSocializeDriver;
use App\Helpers\Factory\Auth\SocialDriverFactory;
use Tests\TestCase;

class OkTest extends TestCase
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
            "uid" => "574049734158",
            "birthday" => "1995-06-26",
            "birthdaySet" => true,
            "age" => 24,
            "first_name" => "Alexander",
            "last_name" => "Fomenko",
            "name" => "Alexander Fomenko",
            "locale" => "ru",
            "gender" => "male",
            "has_email" => true,
            "location" => [
                "city" => "Луганск",
                "country" => "UKRAINE",
                "countryCode" => "UA",
                "countryName" => "Украина",
            ],
            "online" => "web",
            "pic_1" => "https://api.ok.ru/img/stub/user/male/50.png",
            "pic_2" => "https://api.ok.ru/img/stub/user/male/128.png",
            "pic_3" => "https://api.ok.ru/img/stub/user/male/190.png",
        ];
        $this->inc = $this->factory->getInstance('odnoklassniki');
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
        $this->assertEquals('https://api.ok.ru/img/stub/user/male/190.png', $inc->getAvatar());
    }
}

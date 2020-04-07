<?php

namespace Tests\Unit\User\Company;

use App\Entity\User\Company\Company;
use App\Entity\User\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class CompanyTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * @var User|mixed
     */
    private $user;
    /**
     * @var Company|mixed
     */
    private $company;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = factory(User::class)->create();

        $this->company = factory(Company::class)->create([
            'user_id' => $this->user->id,
            'name' => 'test name',
            'description' => 'some description',
            'workers_count' => 13
        ]);
    }

    public function testBaseEntity()
    {
        $this->assertEquals('test name', $this->company->name);
        $this->assertEquals('some description', $this->company->description);
        $this->assertEquals(13, $this->company->workers_count);
        $this->assertEquals($this->user->id, $this->company->user->id);
    }
}

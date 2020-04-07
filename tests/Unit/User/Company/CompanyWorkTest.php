<?php

namespace Tests\Unit\User\Company;

use App\Entity\User\Company\Company;
use App\Entity\User\Company\Portfolio\Work;
use App\Entity\User\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class CompanyWorkTest extends TestCase
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

    public function testCompanyCreateWork()
    {
        $this->assertEquals(0, $this->company->works->count());

        /** @var Work $work */
        $work = $this->company->works()->save(factory(Work::class)->make([
            'title' => 'Test work',
            'description' => 'Test work description',
            'price' => 100500,
            'duration' => 1,
            'duration_type' => Work::DURATION_TYPE_DAYS,
            'user_id' => $this->user->id
        ]));

        $this->assertEquals($this->user->id, $work->user->id);
        $this->assertEquals(Work::getDurationTypes()[Work::DURATION_TYPE_DAYS], $work->getDurationType());
        $this->assertTrue($work->isDurationFilled());
        $this->assertTrue($work->isDaysDuration());
    }

    public function testCompanyCreateWorkWithoutDuration()
    {
        $this->assertEquals(0, $this->company->works->count());

        /** @var Work $work */
        $work = $this->company->works()->save(factory(Work::class)->make([
            'title' => 'Test work',
            'description' => 'Test work description',
            'price' => 100500,
            'user_id' => $this->user->id,
            'duration' => null,
            'duration_type' => null,
        ]));

        $this->assertNull($work->getDurationType());
        $this->assertFalse($work->isDaysDuration());
        $this->assertFalse($work->isMonthsDuration());
    }
}

<?php

namespace Tests\Unit\User\Company;

use App\Entity\Advert\Category;
use App\Entity\User\Company\Company;
use App\Entity\User\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class CompanyCategoriesTest extends TestCase
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

    public function testCompanyCategoriesRemove()
    {
        $this->company->categories()->saveMany(factory(Category::class, 5)->make());
        $this->assertCount(5, $this->company->categories);
        $this->company->categories()->detach();

        $this->assertEquals(0, $this->company->categories()->count());

        $this->company->categories()->saveMany(factory(Category::class, 3)->make());
        $this->assertEquals(3, $this->company->categories()->count());
    }
}

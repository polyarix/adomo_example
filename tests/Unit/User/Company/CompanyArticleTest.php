<?php

namespace Tests\Unit\User\Company;

use App\Entity\User\Company\Article;
use App\Entity\User\Company\Company;
use App\Entity\User\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class CompanyArticleTest extends TestCase
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

    public function testCompanyCreateArticle()
    {
        $this->assertEquals(0, $this->company->articles->count());

        /** @var Article $article  */
        $article = $this->company->articles()->save(factory(Article::class)->make([
            'user_id' => $this->user->id
        ]));

        $this->assertFalse($article->isVisible());

        $this->expectException(\DomainException::class);
        $this->expectExceptionMessage('The article is already hidden.');

        $article->toHidden();
    }

    public function testArticleChangeStatusToVisible()
    {
        /** @var Article $article  */
        $article = $this->company->articles()->save(factory(Article::class)->make([
            'user_id' => $this->user->id
        ]));

        $article->toVisible();

        $this->assertTrue($article->isVisible());

        $this->expectException(\DomainException::class);
        $this->expectExceptionMessage('The article is already visible.');

        $article->toVisible();
    }
}

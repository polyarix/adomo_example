<?php

namespace Tests\Unit\User\Company;

use App\Entity\User\Company\Company;
use App\Entity\User\Company\Contact;
use App\Entity\User\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class CompanyContactTest extends TestCase
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

    public function testCompanyCreateContacts()
    {
        $this->assertNull($this->company->contacts);

        /** @var Contact $contact */
        $contact = $this->company->contacts()->create([
            'address' => 'Random address',
            'contacts' => '+7997979797, admin@admin.com',
            'schedule' => 'Mn-St 10-18',
        ]);

        $this->assertFalse($contact->hasMapCoordinates());
        $this->assertEquals('Random address', $contact->address);
        $this->assertEquals('+7997979797, admin@admin.com', $contact->contacts);
        $this->assertEquals('Mn-St 10-18', $contact->schedule);
    }

    public function testCompanyCreateWithCoordinatesContacts()
    {
        $this->assertNull($this->company->contacts);

        /** @var Contact $contact */
        $contact = $this->company->contacts()->save(factory(Contact::class)->make([
            'map_lat' => 1.00001,
            'map_long' => 91.00003
        ]));

        $this->assertTrue($contact->hasMapCoordinates());
        $this->assertEquals([1.00001, 91.00003], $contact->getCoordinates());
    }
}

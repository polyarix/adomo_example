<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(AdvertOrdersTableSeeder::class);
        $this->call(RegionsTableSeeder::class);
        $this->call(CitiesTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(VariablesTableSeeder::class);
        $this->call(FaqQuestionsSeeder::class);
        $this->call(PageSlugsSeeder::class);
        $this->call(AdvertCategoriesTableSeeder::class);
        $this->call(AdvertPhotosTableSeeder::class);
        $this->call(AdvertVideosTableSeeder::class);
        $this->call(BannersTableSeeder::class);
        $this->call(BlogArticlesTableSeeder::class);
        $this->call(BlogCategoriesTableSeeder::class);
        $this->call(CategoryDimensionsTableSeeder::class);
        $this->call(CategoryTagsTableSeeder::class);
        $this->call(CityDistrictsTableSeeder::class);
        $this->call(CommonVariablesTableSeeder::class);
        $this->call(CompanyWorkPhotosTableSeeder::class);
        $this->call(ContactRequestsTableSeeder::class);
        $this->call(FaqQuestionsTableSeeder::class);
        $this->call(SlidersTableSeeder::class);
        $this->call(SlugsTableSeeder::class);
        $this->call(UserExecutorCategoriesTableSeeder::class);
        $this->call(UserExecutorWorkDataTableSeeder::class);
        $this->call(UserNetworksTableSeeder::class);
        $this->call(TariffServicesTableSeeder::class);
        $this->call(AdvertServicesTableSeeder::class);
    }
}

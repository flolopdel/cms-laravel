<?php

use Faker\Factory as Faker;
use App\Models\ProductType;
use App\Repositories\ProductTypeRepository;

trait MakeProductTypeTrait
{
    /**
     * Create fake instance of ProductType and save it in database
     *
     * @param array $productTypeFields
     * @return ProductType
     */
    public function makeProductType($productTypeFields = [])
    {
        /** @var ProductTypeRepository $productTypeRepo */
        $productTypeRepo = App::make(ProductTypeRepository::class);
        $theme = $this->fakeProductTypeData($productTypeFields);
        return $productTypeRepo->create($theme);
    }

    /**
     * Get fake instance of ProductType
     *
     * @param array $productTypeFields
     * @return ProductType
     */
    public function fakeProductType($productTypeFields = [])
    {
        return new ProductType($this->fakeProductTypeData($productTypeFields));
    }

    /**
     * Get fake data of ProductType
     *
     * @param array $postFields
     * @return array
     */
    public function fakeProductTypeData($productTypeFields = [])
    {
        $fake = Faker::create();

        return array_merge([
            'name' => $fake->word,
            'created_at' => $fake->word,
            'updated_at' => $fake->word
        ], $productTypeFields);
    }
}

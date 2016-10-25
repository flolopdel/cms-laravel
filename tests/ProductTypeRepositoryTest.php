<?php

use App\Models\ProductType;
use App\Repositories\ProductTypeRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ProductTypeRepositoryTest extends TestCase
{
    use MakeProductTypeTrait, ApiTestTrait, DatabaseTransactions;

    /**
     * @var ProductTypeRepository
     */
    protected $productTypeRepo;

    public function setUp()
    {
        parent::setUp();
        $this->productTypeRepo = App::make(ProductTypeRepository::class);
    }

    /**
     * @test create
     */
    public function testCreateProductType()
    {
        $productType = $this->fakeProductTypeData();
        $createdProductType = $this->productTypeRepo->create($productType);
        $createdProductType = $createdProductType->toArray();
        $this->assertArrayHasKey('id', $createdProductType);
        $this->assertNotNull($createdProductType['id'], 'Created ProductType must have id specified');
        $this->assertNotNull(ProductType::find($createdProductType['id']), 'ProductType with given id must be in DB');
        $this->assertModelData($productType, $createdProductType);
    }

    /**
     * @test read
     */
    public function testReadProductType()
    {
        $productType = $this->makeProductType();
        $dbProductType = $this->productTypeRepo->find($productType->id);
        $dbProductType = $dbProductType->toArray();
        $this->assertModelData($productType->toArray(), $dbProductType);
    }

    /**
     * @test update
     */
    public function testUpdateProductType()
    {
        $productType = $this->makeProductType();
        $fakeProductType = $this->fakeProductTypeData();
        $updatedProductType = $this->productTypeRepo->update($fakeProductType, $productType->id);
        $this->assertModelData($fakeProductType, $updatedProductType->toArray());
        $dbProductType = $this->productTypeRepo->find($productType->id);
        $this->assertModelData($fakeProductType, $dbProductType->toArray());
    }

    /**
     * @test delete
     */
    public function testDeleteProductType()
    {
        $productType = $this->makeProductType();
        $resp = $this->productTypeRepo->delete($productType->id);
        $this->assertTrue($resp);
        $this->assertNull(ProductType::find($productType->id), 'ProductType should not exist in DB');
    }
}

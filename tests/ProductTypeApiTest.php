<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ProductTypeApiTest extends TestCase
{
    use MakeProductTypeTrait, ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function testCreateProductType()
    {
        $productType = $this->fakeProductTypeData();
        $this->json('POST', '/api/v1/productTypes', $productType);

        $this->assertApiResponse($productType);
    }

    /**
     * @test
     */
    public function testReadProductType()
    {
        $productType = $this->makeProductType();
        $this->json('GET', '/api/v1/productTypes/'.$productType->id);

        $this->assertApiResponse($productType->toArray());
    }

    /**
     * @test
     */
    public function testUpdateProductType()
    {
        $productType = $this->makeProductType();
        $editedProductType = $this->fakeProductTypeData();

        $this->json('PUT', '/api/v1/productTypes/'.$productType->id, $editedProductType);

        $this->assertApiResponse($editedProductType);
    }

    /**
     * @test
     */
    public function testDeleteProductType()
    {
        $productType = $this->makeProductType();
        $this->json('DELETE', '/api/v1/productTypes/'.$productType->id);

        $this->assertApiSuccess();
        $this->json('GET', '/api/v1/productTypes/'.$productType->id);

        $this->assertResponseStatus(404);
    }
}

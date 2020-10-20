<?php

namespace Tests\Feature\Front;

use App\Shop\Categories\Category;
use App\Shop\Products\Product;
use App\Shop\Products\Repositories\ProductRepository;
use Tests\TestCase;

class FrontCategoryFeatureTest extends TestCase
{
    /** @test */
    public function it_can_show_the_categories_and_products_associated_with_it()
    {
        $category = factory(Category::class)->create();
        $product = factory(Product::class)->create();

        $productRepo = new ProductRepository($product);
        $productRepo->syncCategories([$category->id]);

        $this
            ->get(route('front.category.slug', str_slug($category->name)))
            ->assertStatus(200)
            ->assertSee($category->name)
            ->assertSee($product->name)
            ->assertSee($product->description)
            ->assertSee((string)$product->quantity)
            ->assertSee((string)$product->price);
    }

    /** @test */
    public function it_displays_subcategories_assigned_to_parent_category()
    {
        $category1 = factory(Category::class)->create();
        $subCategory1 = factory(Category::class)->create(['name' => 'Child-Category-1', 'parent_id' => $category1->id]);
        $subCategory2 = factory(Category::class)->create(['name' => 'Child-Category-2', 'parent_id' => $category1->id]);
        $subSubCategory1 = factory(Category::class)->create(['name' => 'Grand-Child-Category-1', 'parent_id' => $subCategory1->id]);

        $this
            ->get(route('front.category.slug', str_slug($category1->name)))
            ->assertStatus(200)
            ->assertSee($category1->name)
            ->assertSee($subCategory1->name)
            ->assertSee($subCategory2->name)
            ->assertSee($subSubCategory1->name);
    }

    /** @test */
    public function it_displays_subcategories_assigned_to_parent_category_when_viewing_subCategory()
    {
        $category1 = factory(Category::class)->create();
        $subCategory1 = factory(Category::class)->create(['name' => 'Child-Category-1', 'slug' => 'child-category-1', 'parent_id' => $category1->id]);
        $subCategory2 = factory(Category::class)->create(['name' => 'Child-Category-2', 'slug' => 'child-category-2', 'parent_id' => $category1->id]);
        $subSubCategory1 = factory(Category::class)->create(['name' => 'Grand-Child-Category-1', 'parent_id' => $subCategory1->id]);

        $this
            ->get(route('front.category.slug', str_slug($subCategory1->name)))
            ->assertStatus(200)
            ->assertSee($category1->name)
            ->assertSee($subCategory1->name)
            ->assertSee($subCategory2->name)
            ->assertSee($subSubCategory1->name);
    }

    /** @test */
    public function it_displays_only_subcategories_assigned_to_parent_category()
    {
        $category1 = factory(Category::class)->create();
        $subCategory1 = factory(Category::class)->create(['name' => 'Child-Category-1', 'parent_id' => $category1->id]);
        $subSubCategory1 = factory(Category::class)->create(['name' => 'Grand-Child-Category-1', 'parent_id' => $subCategory1->id]);

        $category2 = factory(Category::class)->create();
        $subCategory2 = factory(Category::class)->create(['name' => 'Child-Category-2', 'parent_id' => $category2->id]);
        $subSubCategory2 = factory(Category::class)->create(['name' => 'Grand-Child-Category-2', 'parent_id' => $subCategory2->id]);
        $this
            ->get(route('front.category.slug', str_slug($category2->name)))
            ->assertStatus(200)
            ->assertSee($category2->name)
            ->assertSee($subCategory2->name)
            ->assertSee($subSubCategory2->name)
           // ->assertDontSee($category1->name) // we cant test for these as the links also appear in the main menu
           // ->assertDontSee($subCategory1->name) // we cant test for these as the links also appear in the main menu
            ->assertDontSee($subSubCategory1->name);
    }
}

<?php

namespace App\Http\Controllers\Front;

use App\Shop\Categories\Repositories\Interfaces\CategoryRepositoryInterface;
use App\Shop\Slides\Slide;

class HomeController
{
    /**
     * @var CategoryRepositoryInterface
     */
    private $categoryRepo;

    /**
     * HomeController constructor.
     * @param CategoryRepositoryInterface $categoryRepository
     */
    public function __construct(CategoryRepositoryInterface $categoryRepository)
    {
        $this->categoryRepo = $categoryRepository;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $cat1 = $this->categoryRepo->findCategoryById(2);
        $cat2 = $this->categoryRepo->findCategoryById(3);

        $slides = Slide::where('status', true)->orderby('id', 'desc')->limit(10)->get();

        return view('front.index', compact('cat1', 'cat2', 'slides'));
    }
}

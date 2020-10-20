@isset($parentCategory)
    <h2><a @if(request()->segment(2) === $parentCategory->slug) class="active" @endif
        href="{{ route('front.category.slug', $parentCategory->slug) }}">{{ $parentCategory->name }}</a>
    </h2>
@endisset

@isset($childCategories)
    @foreach($childCategories as $category)
        @if($loop->first)
            <ul class="nav sidebar-menu">
                @endif

                @if($category->children()->count() > 0)
                    <li>@include('layouts.front.category-sidebar-sub', ['subs' => $category->children])</li>
                @else
                    <li @if(request()->segment(2) === $category->slug) class="active" @endif><a
                                href="{{ route('front.category.slug', $category->slug) }}">{{ $category->name }}</a>
                    </li>
                @endif

                @if($loop->last)
            </ul>
        @endif
    @endforeach
@endisset

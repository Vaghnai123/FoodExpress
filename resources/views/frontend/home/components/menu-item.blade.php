<section class="fp__menu mt_95 xs_mt_65">
    <div class="container">
        <div class="row wow fadeInUp" data-wow-duration="1s">
            <div class="col-md-8 col-lg-7 col-xl-6 m-auto text-center">

                <div class="fp__section_heading mb_45">
                    <h4>{{ @$sectionTitles['menu_top_title'] }}</h4>
                    <h2>{{ @$sectionTitles['menu_main_title'] }}</h2>
                    <span>
                        <img src="{{ asset('frontend/images/heading_shapes.png') }}" alt="shapes"
                            class="img-fluid w-100">
                    </span>
                    <p>{{ @$sectionTitles['menu_sub_title'] }}</p>
                </div>
            </div>
        </div>

        <div class="row wow fadeInUp" data-wow-duration="1s">
            <div class="col-12">
                <div class="menu_filter d-flex flex-wrap justify-content-center">
                    @foreach ($categories as $category)
                        <button class="{{ $loop->index === 0 ? 'active button-click' : '' }}"
                            data-filter=".{{ $category->slug }}">{{ $category->name }}</button>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="row grid">
            @foreach ($categories as $category)
                @php
                    $products = \App\Models\Product::where([
                        'show_at_home' => 1,
                        'status' => 1,
                        'category_id' => $category->id,
                    ])
                        ->orderBy('id', 'DESC')
                        ->take(8)
                        ->withAvg('reviews', 'rating')
                        ->withCount('reviews')
                        ->get();
                @endphp

                @foreach ($products as $product)
                    <div class="col-12 col-sm-6 col-md-6 col-lg-4 col-xl-3 {{ $category->slug }} wow fadeInUp"
                        data-wow-duration="1s">
                        <div class="fp__menu_item">
                            <div class="fp__menu_item_img">
                                <img src="{{ asset($product->thumb_image) }}" alt="{{ $product->name }}"
                                    class="img-fluid w-100" style="height: 100%; object-fit: cover;">
                                <a class="category" href="#">{{ @$product->category->name }}</a>
                            </div>

                            <div class="fp__menu_item_text">
                                @if ($product->reviews_avg_rating)
                                    <p class="rating">
                                        @for ($i = 1; $i <= $product->reviews_avg_rating; $i++)
                                            <i class="fas fa-star"></i>
                                        @endfor

                                        <span>({{ $product->reviews_count }})</span>
                                    </p>
                                @endif

                                <a class="title"
                                    href="{{ route('product.show', $product->slug) }}">{{ $product->name }}</a>

                                <p class="description mt-2 mb-4" title="{{ strip_tags($product->short_description) }}"
                                    style="font-size: 14px; color: #6c757d; line-height: 1.4; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; text-overflow: ellipsis; word-break: break-word; cursor: pointer;">
                                    {{ strip_tags($product->short_description) }}
                                </p>

                                <h5 class="price">
                                    @if ($product->offer_price > 0)
                                        {{ currencyPosition($product->offer_price) }}
                                        <del>{{ currencyPosition($product->price) }}</del>
                                    @else
                                        {{ currencyPosition($product->price) }}
                                    @endif
                                </h5>

                                <ul class="d-flex flex-wrap justify-content-center">
                                    <li><a href="javascript:;" onclick="loadProductModal('{{ $product->id }}')"><i
                                                class="fas fa-shopping-basket"></i></a></li>
                                    <li onclick="addToWishlist('{{ $product->id }}')"><a href="javascript:;"><i class="fal fa-heart"></i></a></li>
                                    <li><a href="{{ route('product.show', $product->slug) }}"><i class="far fa-eye"></i></a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endforeach
        </div>
    </div>
</section>

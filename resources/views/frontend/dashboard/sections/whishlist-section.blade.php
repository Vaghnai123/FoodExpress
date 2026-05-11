<div class="tab-pane fade" id="v-pills-wishlist" role="tabpanel" aria-labelledby="v-pills-wishlist-tab">
    <div class="fp_dashboard_body">
        <h3 class="text-capitalize mb-4 pb-3"
            style="font-weight: 700; color: #2b2b2b; font-size: 20px; border-bottom: 2px solid #d19106;">
            My Wishlist
        </h3>
        <div class="fp__dashoard_wishlist">

            <div class="row">
                @forelse ($wishlist as $item)
                    @php
                        $product = $item->product;
                    @endphp

                    <div class="col-xl-4 col-sm-6 col-lg-6 mb-4">
                        <div class="fp__menu_item">
                            <div class="fp__menu_item_img">
                                <img src="{{ asset($product->thumb_image) }}" alt="{{ $product->name }}"
                                    class="img-fluid w-100" style="height: 100%; object-fit: cover;">
                                <a class="category" href="javascript:;">{{ @$product->category->name }}</a>
                            </div>

                            <div class="fp__menu_item_text">

                                <a class="title"
                                    href="{{ route('product.show', $product->slug) }}">{{ $product->name }}</a>

                                <p class="description mt-2 mb-4" title="{{ strip_tags($product->short_description) }}"
                                    style="font-size: 14px; color: #6c757d; line-height: 1.4; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; text-overflow: ellipsis; word-break: break-word; cursor: pointer;">
                                    {{ strip_tags($product->short_description) }}
                                </p>

                                {{-- Price Logic --}}
                                <h5 class="price">
                                    @if ($product->offer_price > 0)
                                        {{ currencyPosition($product->offer_price) }}
                                        <del>{{ currencyPosition($product->price) }}</del>
                                    @else
                                        {{ currencyPosition($product->price) }}
                                    @endif
                                </h5>

                                {{-- Action Buttons --}}
                                <ul class="d-flex flex-wrap justify-content-center">
                                    <li>
                                        <a href="javascript:;" onclick="loadProductModal('{{ $product->id }}')">
                                            <i class="fas fa-shopping-basket"></i>
                                        </a>
                                    </li>

                                    <li>
                                        <a href="{{ route('product.show', $product->slug) }}">
                                            <i class="far fa-eye"></i>
                                        </a>
                                    </li>

                                    <li>
                                        <a href="{{ route('wishlist.destroy', $item->id) }}" class="delete-item">
                                            <i class="fas fa-trash-alt"></i>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    @if ($wishlist->hasPages())
                        <div class="fp__pagination mt_60">
                            <div class="row">
                                <div class="col-12">
                                    {{ $wishlist->links() }}
                                </div>
                            </div>
                        </div>
                    @endif

                @empty
                    <div class="col-12 text-center mt-5">
                        <h5 class="text-muted">Your wishlist is empty!</h5>
                    </div>
                @endforelse
            </div>

        </div>
    </div>
</div>

<div class="tab-pane fade" id="v-pills-review" role="tabpanel" aria-labelledby="v-pills-review-tab">
    <div class="fp_dashboard_body dashboard_review">
        <h3 class="text-capitalize mb-4 pb-3"
            style="font-weight: 700; color: #2b2b2b; font-size: 20px; border-bottom: 2px solid #d19106;">
            My Reviews
        </h3>
        <div class="fp__review_area">
            <div class="fp__comment pt-1 mt_20">
                @forelse ($reviews as $review)
                    <div class="fp__single_comment border-0 {{ !$loop->last ? 'pb-4 mb-4' : 'm-0' }}"
                        style="{{ !$loop->last ? 'border-bottom: 1px solid #d1d5db !important;' : '' }}">
                        <img src="{{ !empty($review->user->avatar) ? asset($review->user->avatar) : asset('default-avatar.jpg') }}"
                            alt="review" class="img-fluid">
                        <div class="fp__single_comm_text">
                            <h3><a href="javascript:;">{{ $review->user->name }}</a>
                                <span>{{ date('d-m-Y', strtotime($review->created_at)) }} </span>
                            </h3>
                            <span class="rating">
                                @for ($i = 1; $i <= $review->rating; $i++)
                                    <i class="fas fa-star"></i>
                                @endfor
                            </span>
                            <p>{{ $review->review }}</p>
                            @if ($review->status === 1)
                                <span class="status active">Active</span>
                            @else
                                <span class="status inactive">Pending</span>
                            @endif
                        </div>
                    </div>

                    @if ($reviews->hasPages())
                        <div class="fp__pagination mt_60">
                            <div class="row">
                                <div class="col-12">
                                    {{ $reviews->links() }}
                                </div>
                            </div>
                        </div>
                    @endif

                @empty
                    <div class="col-12 text-center mt-5">
                        <h5 class="text-muted">No reviews added yet!</h5>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>

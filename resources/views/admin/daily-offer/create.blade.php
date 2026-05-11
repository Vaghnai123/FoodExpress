@extends('admin.layouts.master')

@push('styles')
    <style>
        .select2-container .select2-selection--single {
            height: 42px !important;
            border-color: #e4e6fc;
        }

        .select2-container .select2-selection--single .select2-selection__rendered {
            line-height: 42px !important;
            padding-left: 15px;
        }

        .select2-container .select2-selection--single .select2-selection__arrow {
            height: 42px !important;
        }
    </style>
@endpush

@section('content')
    <section class="section">
        <div class="section-header shadow-sm"
            style="background-color: #fff; padding: 20px 25px; border-radius: 5px; margin-bottom: 25px; display: flex; justify-content: space-between; align-items: center;">
            <h1 style="margin: 0; font-size: 18px; color: #34395e;">
                <i class="fas fa-tags" style="color: #6777ef; margin-right: 10px;"></i> Daily Offer
            </h1>
        </div>

        <div class="card card-primary">
            <div class="card-header">
                <h4>Create Daily Offer</h4>

            </div>
            <div class="card-body">
                <form action="{{ route('admin.daily-offer.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="form-group">
                        <label>Product</label>
                        <select name="product" class="select2 form-control" id="product_search">
                            <option value="">Select</option>

                        </select>
                    </div>


                    <div class="form-group">
                        <label>Status</label>
                        <select name="status" class="select2 form-control" id="">
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        </select>
                    </div>


                    <button type="submit" class="btn btn-primary">Create</button>
                </form>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $('#product_search').select2({
                ajax: {
                    url: '{{ route("admin.daily-offer.search-product") }}',
                    data: function(params) {
                        var query = {
                            search: params.term,
                            type: 'public'
                        }

                        // Query parameters will be ?search=[term]&type=public
                        return query;
                    },
                    processResults: function(data){
                        return {
                            results: $.map(data, function(product){
                                return {
                                    text: product.name,
                                    id:product.id,
                                    image_url: product.thumb_image
                                }
                            })
                        }
                    }
                },
                minimumInputLength: 3,
                templateResult: formatProduct,
                escapeMarkup: function(m) {return m;}

            });

            function formatProduct (product){
                var product = $('<span><img src="'+product.image_url+'" class="img-thumbnail" width="50" >  '+product.text+'</span>');
                return product;
            }
        })
    </script>
@endpush

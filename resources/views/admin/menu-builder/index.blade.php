@extends('admin.layouts.master')

@push('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/nestable2/1.6.0/jquery.nestable.min.css">
    <style>
        .dd {
            max-width: 100%;
        }

        .dd-item>button {
            margin-top: 8px;
        }

        .dd-list .dd-list {
            padding-left: 30px !important;
        }

        .dd-handle {
            display: flex;
            align-items: center;
            margin: 5px 0;
            padding: 0 15px;
            min-height: 45px;
            color: #333;
            text-decoration: none;
            font-weight: bold;
            border: 1px solid #e4e6fc;
            background: #f8fafb;
            border-radius: 3px;
            box-sizing: border-box;
            cursor: move;
        }

        .dd-handle:hover {
            background: #f1f4f5;
        }

        .dd-placeholder,
        .dd-empty {
            margin: 5px 0;
            padding: 0;
            min-height: 40px;
            background: #f2fbff;
            border: 2px dashed #6777ef;
            box-sizing: border-box;
        }

        .item-settings {
            position: absolute;
            right: 15px;
            top: 27px;
            transform: translateY(-50%);
            cursor: pointer;
            color: #6777ef;
            z-index: 10;
        }

        .menu-details-form {
            background: #fdfdfd;
            padding: 15px;
            border: 1px solid #e4e6fc;
            margin-bottom: 10px;
            display: none;
            border-radius: 3px;
        }
    </style>
@endpush

@section('content')
    <section class="section">

        <div class="section-header shadow-sm"
            style="background-color: #fff; padding: 20px 25px; border-radius: 5px; margin-bottom: 25px; display: flex; justify-content: space-between; align-items: center;">
            <h1 style="margin: 0; font-size: 18px; color: #34395e;">
                <i class="fas fa-list" style="color: #6777ef; margin-right: 10px;"></i> Menu Builder
            </h1>
        </div>

        <div class="alert alert-info alert-has-icon">
            <div class="alert-icon"><i class="far fa-lightbulb"></i></div>
            <div class="alert-body">
                <div class="alert-title">Important Note For Creating Menus</div>
                To display the menus correctly on the frontend, please make sure to create menus with <strong>exactly</strong> these names :-
                <ul class="mb-0 mt-2" style="font-weight: 600;">
                    <li>Main Menu <span class="text-dark font-weight-normal">( <b>For Top Navigation</b> )</span></li>
                    <li>Footer Short Links <span class="text-dark font-weight-normal">( <b>For First Footer Section</b> )</span></li>
                    <li>Footer Help Links <span class="text-dark font-weight-normal">( <b>For Second Footer Section</b> )</span></li>
                    <li>Footer Bottom Links <span class="text-dark font-weight-normal">( <b>For Bottom Footer Section</b> )</span></li>
                </ul>
            </div>
        </div>

        <div class="row">
            <!-- Left Column: Menu Selection & Addition -->
            <div class="col-md-4">
                <div class="card card-primary">
                    <div class="card-header">
                        <h4>Select Menu</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.menus.index') }}" method="GET">
                            <div class="form-group">
                                <select name="menu_id" class="form-control" onchange="this.form.submit()">
                                    <option value="">-- Choose Menu --</option>
                                    @foreach ($menus as $menu)
                                        <option value="{{ $menu->id }}"
                                            {{ $selectedMenu && $selectedMenu->id == $menu->id ? 'selected' : '' }}>
                                            {{ $menu->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </form>

                        <hr>

                        <h6>Create New Menu</h6>
                        <form action="{{ route('admin.menus.store') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <input type="text" name="name" class="form-control"
                                    placeholder="Menu Name (e.g., Main Menu)" required>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Create Menu</button>
                        </form>
                    </div>
                </div>

                @if ($selectedMenu)
                    <div class="card card-warning mt-4">
                        <div class="card-header">
                            <h4>Add Menu Item</h4>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('admin.menus.items.store') }}" method="POST">
                                @csrf
                                <input type="hidden" name="menu_id" value="{{ $selectedMenu->id }}">

                                <div class="form-group">
                                    <label>Label</label>
                                    <input type="text" name="label" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label>URL / Route</label>
                                    <input type="text" name="link" class="form-control"
                                        placeholder="/about or https://..." required>
                                </div>
                                <div class="form-group">
                                    <label>Parent Item (Which parent item should placed under?)</label>
                                    <select name="parent_id" class="form-control">
                                        <option value="0">None (Main Menu Item)</option>
                                        @foreach ($allMenuItems as $parent)
                                            <option value="{{ $parent->id }}">{{ $parent->label }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Target</label>
                                    <select name="target" class="form-control">
                                        <option value="_self">Same Window (_self)</option>
                                        <option value="_blank">New Window (_blank)</option>
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-warning w-100">Add to Menu</button>
                            </form>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Right Column: Nestable Menu Items -->
            <div class="col-md-8">
                <div class="card card-success">
                    <div class="card-header">
                        <h4>Menu Structure :- {{ $selectedMenu ? $selectedMenu->name : 'None Selected' }}</h4>
                        @if ($selectedMenu)
                            <div class="card-header-action">
                                <form action="{{ route('admin.menus.destroy', $selectedMenu->id) }}" method="POST"
                                    onsubmit="return confirm('Delete this entire menu?');">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-danger btn-sm">Delete Menu</button>
                                </form>
                            </div>
                        @endif
                    </div>
                    <div class="card-body">
                        @if ($selectedMenu)
                            <p class="text-muted">Drag each item into the order you prefer. Click the arrow on the right to
                                reveal configuration options.</p>

                            <div class="dd" id="nestable">
                                <ol class="dd-list">
                                    @foreach ($menuItems as $item)
                                        @include('admin.menu-builder._menu_item', ['item' => $item])
                                    @endforeach
                                </ol>
                            </div>
                            <hr>
                            <button id="save-menu" class="btn btn-success">Save Sorting</button>
                        @else
                            <p>Please select or create a menu to manage its items.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/nestable2/1.6.0/jquery.nestable.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#nestable').nestable({
                maxDepth: 5
            });

            $('.toggle-item-settings').on('click', function() {
                $(this).closest('li').find('.menu-details-form').first().slideToggle();
            });

            $('#save-menu').on('click', function() {
                let order = window.JSON.stringify($('#nestable').nestable('serialize'));
                let btn = $(this);
                btn.addClass('btn-progress');

                $.ajax({
                    url: '{{ route('admin.menus.items.sort') }}',
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        order: order
                    },
                    success: function(response) {
                        btn.removeClass('btn-progress');
                        toastr.success(response.message);
                    },
                    error: function() {
                        btn.removeClass('btn-progress');
                        toastr.error('Something went wrong!');
                    }
                });
            });
        });
    </script>
@endpush

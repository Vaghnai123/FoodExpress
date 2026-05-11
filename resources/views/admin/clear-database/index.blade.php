@extends('admin.layouts.master')

@section('content')
    <section class="section">

        <div class="section-header shadow-sm"
            style="background-color: #fff; padding: 20px 25px; border-radius: 5px; margin-bottom: 25px; display: flex; justify-content: space-between; align-items: center;">
            <h1 style="margin: 0; font-size: 18px; color: #34395e;">
                <i class="fas fa-database" style="color: #6777ef; margin-right: 10px;"></i> Clear Specific Table Data
            </h1>
        </div>

        <div class="card card-primary">
            <div class="card-header">
                <h4>Select Table to Clear</h4>
            </div>
            <div class="card-body">
                <div class="alert alert-warning alert-has-icon">
                    <div class="alert-icon"><i class="fas fa-exclamation-triangle"></i></div>
                    <div class="alert-body">
                        <div class="alert-title">Warning</div>
                        Clearing a table will permanently delete all its rows and reset the auto-increment ID. This action
                        cannot be undone.
                    </div>
                </div>

                <form id="clearTableForm" class="mt-4">
                    <div class="form-group">
                        <label for="table_name">Database Table</label>
                        <select name="table_name" id="table_name" class="form-control" required>
                            <option value="">-- Select a Table to Clear --</option>
                            @foreach ($allowedTables as $table)
                                <option value="{{ $table }}">{{ $table }}</option>
                            @endforeach
                        </select>
                    </div>

                    <button class="btn btn-danger submit_button" type="submit">
                        <i class="fas fa-trash-alt"></i> <b>Clear Table Data</b>
                    </button>
                </form>
            </div>
        </div>

        <div class="card card-warning">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4>Manage Uploaded Files</h4>
                <button type="button" class="btn btn-danger d-none" id="deleteSelectedFilesBtn">
                    <i class="fas fa-trash"></i> Delete Selected
                </button>
            </div>
            <div class="card-body">
                @if(count($files) > 0)
                    <div class="custom-control custom-checkbox mb-3">
                        <input type="checkbox" class="custom-control-input" id="selectAllFiles">
                        <label class="custom-control-label font-weight-bold text-dark" for="selectAllFiles">Select All Files</label>
                    </div>

                    <div class="row">
                        @foreach($files as $file)
                            <div class="col-lg-2 col-md-3 col-sm-4 col-6 mb-4">
                                <div class="border rounded p-2 text-center position-relative h-100 shadow-sm file-card">

                                    <div class="custom-control custom-checkbox position-absolute" style="top: 1px; left: 10px; z-index: 10;">
                                        <input type="checkbox" class="custom-control-input file-checkbox" id="file_{{ $loop->index }}" value="{{ $file['name'] }}">
                                        <label class="custom-control-label" for="file_{{ $loop->index }}"></label>
                                    </div>

                                    <div class="mt-2 bg-light d-flex align-items-center justify-content-center rounded" style="height: 110px; overflow: hidden;">
                                        @if(in_array($file['ext'], ['jpg', 'jpeg', 'png', 'gif', 'svg', 'webp']))
                                            <img src="{{ $file['path'] }}" alt="{{ $file['name'] }}" class="img-fluid" style="max-height: 100%; max-width: 100%; object-fit: contain; padding: 5px;">
                                        @else
                                            <i class="fas fa-file-alt text-muted" style="font-size: 50px;"></i>
                                        @endif
                                    </div>

                                    <div class="mt-3 text-truncate" title="{{ $file['name'] }}" style="font-size: 13px; font-weight: 600;">
                                        {{ $file['name'] }}
                                    </div>
                                    <div class="text-muted mt-1" style="font-size: 11px;">{{ $file['size'] }}</div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-5">
                        <i class="fas fa-folder-open fa-3x text-muted mb-3"></i>
                        <h6>No files found in the uploads directory.</h6>
                    </div>
                @endif
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {

            $('#clearTableForm').on('submit', function(e) {
                e.preventDefault();

                let tableName = $('#table_name').val();

                if (!tableName) {
                    toastr.error("Please select a table first!");
                    return;
                }

                Swal.fire({
                    title: 'Are you absolutely sure?',
                    text: "You are about to wipe all data from '" + tableName +
                        "'. You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Yes, clear it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            method: 'POST',
                            url: "{{ route('admin.clear-database.clearTable') }}",
                            data: {
                                _token: "{{ csrf_token() }}",
                                table_name: tableName
                            },
                            beforeSend: function() {
                                $('.submit_button').prop("disabled", true);
                                $('.submit_button').html(
                                    '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Clearing...'
                                    );
                            },
                            success: function(response) {
                                if (response.status === 'success') {
                                    toastr.success(response.message);

                                    $('#table_name').val('').trigger('change');

                                } else if (response.status === 'error') {
                                    toastr.error(response.message);
                                }
                            },
                            error: function(xhr) {
                                let errorMsg = xhr.responseJSON ? xhr.responseJSON
                                    .message : 'An unexpected error occurred.';
                                toastr.error(errorMsg);
                                console.error(xhr);
                            },
                            complete: function() {
                                $('.submit_button').prop("disabled", false);
                                $('.submit_button').html(
                                    '<i class="fas fa-trash-alt"></i> <b>Clear Table Data</b>'
                                    );
                            }
                        });
                    }
                });
            });

            // --- Upload Image Clear LOGIC ---

            // Select/Deselect All Checkboxes
            $('#selectAllFiles').on('change', function() {
                $('.file-checkbox').prop('checked', $(this).prop('checked'));
                toggleDeleteButton();
            });

            // Individual Checkbox Logic
            $('.file-checkbox').on('change', function() {
                toggleDeleteButton();
                // Check if all are selected manually
                if ($('.file-checkbox:checked').length === $('.file-checkbox').length) {
                    $('#selectAllFiles').prop('checked', true);
                } else {
                    $('#selectAllFiles').prop('checked', false);
                }
            });

            // Show/Hide Delete Button based on selection
            function toggleDeleteButton() {
                let selectedCount = $('.file-checkbox:checked').length;
                if (selectedCount > 0) {
                    $('#deleteSelectedFilesBtn').removeClass('d-none').html('<i class="fas fa-trash"></i> Delete Selected (' + selectedCount + ')');
                } else {
                    $('#deleteSelectedFilesBtn').addClass('d-none');
                }
            }

            // Execute Delete Request
            $('#deleteSelectedFilesBtn').on('click', function() {
                let selectedFiles = [];
                $('.file-checkbox:checked').each(function() {
                    selectedFiles.push($(this).val());
                });

                Swal.fire({
                    title: 'Are you sure?',
                    text: "You are about to delete " + selectedFiles.length + " file(s). This cannot be undone!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Yes, delete them!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        let btn = $('#deleteSelectedFilesBtn');
                        let originalText = btn.html();

                        $.ajax({
                            method: 'POST',
                            url: "{{ route('admin.clear-database.deleteFiles') }}",
                            data: {
                                _token: "{{ csrf_token() }}",
                                selected_files: selectedFiles
                            },
                            beforeSend: function(){
                                btn.prop("disabled", true).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Deleting...');
                            },
                            success: function(response) {
                                if (response.status === 'success') {
                                    toastr.success(response.message);
                                    setTimeout(function() {
                                        window.location.reload();
                                    }, 1000);
                                } else {
                                    toastr.error(response.message);
                                    btn.prop("disabled", false).html(originalText);
                                }
                            },
                            error: function(xhr) {
                                toastr.error('An error occurred while deleting files.');
                                btn.prop("disabled", false).html(originalText);
                            }
                        });
                    }
                });
            });

        });
    </script>
@endpush

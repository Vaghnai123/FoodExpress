<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>403 &mdash; Unauthorized</title>
    <link rel="stylesheet" href="{{ asset('admin/assets/modules/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/assets/css/style.css') }}">
</head>

<body>
    <div id="app">
        <section class="section">
            <div class="container mt-5">
                <div class="page-error">
                    <div class="page-inner">
                        <h1>403</h1>
                        <div class="page-description">You do not have the required permissions to access this page.
                        </div>
                        <div class="page-search">
                            <div class="mt-3"><a href="{{ route('admin.dashboard') }}"
                                    class="btn btn-primary btn-lg">Back to Dashboard</a></div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</body>

</html>

<!DOCTYPE html>

<head>
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ route('dashboard') }}">Dashboard</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('meters') }}">Meters</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('prices') }}">Prices</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="{{ route('new_user') }}">New User</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('new_meter') }}">New Meter</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('new_price') }}">New Price</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('bind_meter_user') }}">Bind Meter</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('new_charge') }}">Create Charge</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container">

        {{ $slot }}

    </div>

</body>

</html>

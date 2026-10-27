@if (session('success'))
    <div class="okb">{{ session('success') }}</div>
@endif
@if (session('error'))
    <div class="alert">⚠ {{ session('error') }}</div>
@endif
@if ($errors->any())
    <div class="alert">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

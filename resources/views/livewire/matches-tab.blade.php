<div class="tab">
    
    @foreach ($pairs as $pair)
        <a class="tab-item" href="{{ $pair['link'] }}">
            <img class="avatar" src="{{ $pair['avatar'] }}" alt="{{ $pair['name'] }} avatar">
            <div class="info">
                <h1>{{ $pair['name'] }}</h1>
                <p @if($pair['message']['isBot']) class="waiting" @endif> {{ $pair['message']['text'] }} </p>
            </div>
        </a>  
    @endforeach

    @if($hasMorePages)
        <div
            x-data
            x-intersect="@this.call('loadPairs')"
        >
            <div class="center-container">
                <img class="loading" src="{{ asset('img/loading.gif') }}" alt="Trwa ładowanie">
            </div>
        </div>
    @endif
</div>

@push('js')
    <script type="module" src="{{ asset('js/app.js') }}"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/intersect@3.x.x/dist/cdn.min.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
@endpush
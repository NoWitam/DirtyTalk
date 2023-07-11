<div id="chat">

    <div class="text">

        @foreach($messages as $message)
            <div class="@if($message['isBot']) talker @else user @endif">
                <div> {{ $message['text'] }} </div>
            </div>
        @endforeach

        @if($hasMorePages)
            <div
                x-data
                x-intersect="@this.call('loadMessages')"
            >
                <div class="center-container">
                    <img class="loading" src="{{ asset('img/loading.gif') }}" alt="Trwa ładowanie">
                </div>
            </div>
        @endif

    </div>

    <hr>

    <div class="input">
        <textarea wire:model.defer="newMessage" placeholder="Aa" maxlength="255"></textarea>
        <button wire:click="send">
            <img src="{{ asset('img/send.png') }}" src="Wyślij">
        </button>
    </div>

</div>

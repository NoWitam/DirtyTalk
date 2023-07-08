
<div class="content">
    <div class="title">
        <h1>Użytkownicy</h1>
        <input wire:model.defer="newBot.name" type="text" placeholder="Imie">
        <textarea wire:model.defer="newBot.description" type="text" placeholder="Opis"></textarea>
        <input wire:model.defer="newBot.birthday" type="date" placeholder="Urodziny">
        <input type="file" wire:model.defer="newBot.image" accept="image/*" multiple>
        <button wire:click="create">Zapisz</button>
    </div>

    <table>
        <tr>
            <th>Imię</th>
            <th>Wiek</th>
            <th>Ilość zdjęć</th>
            <th>Data utworzenia</th>
            <th>Akcje</th>
        </tr>

        @foreach ($bots as $bot)
            <tr>
                <td> {{ $bot['name'] }} </td>
                <td> {{ $bot['age'] }} </td>
                <td> {{ $bot['imageCount'] }}
                <td> {{ $bot['created_at'] }} </td>
                <td><button wire:click="delete({{ $bot['id'] }})"> Usuń </button></td>
            </tr>
        @endforeach
    </table>
</div>
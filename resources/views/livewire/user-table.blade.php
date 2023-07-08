
<div class="content">
    <div class="title">
        <h1>Użytkownicy</h1>
        <input wire:model.defer="newUser.email" type="text" placeholder="Email">
        <input wire:model.defer="newUser.password" type="text" placeholder="Hasło">
        <select wire:model.lazy="newUser.role">
            @foreach (\App\Enums\UserRoleEnum::cases() as $role)
                <option value="{{ $role->value }}"> {{ $role->label() }} </option>
            @endforeach
        </select>
        <button wire:click="create">Zapisz</button>
    </div>

    <table>
        <tr>
            <th>Email</th>
            <th>Rola</th>
            <th>Data utworzenia</th>
            <th>Akcje</th>
        </tr>
        @foreach ($users as $user)
            <tr>
                <td> {{ $user['email'] }} </td>
                <td> {{ $user['role'] }} </td>
                <td> {{ $user['created_at'] }} </td>
                <td><button wire:click="delete({{ $user['id'] }})"> Usuń </button></td>
            </tr>
        @endforeach
    </table>
</div>
@foreach($users as $user)
    <tr data-id="{{ $user->id }}">
        <td><input type="checkbox" class="select-user" value="{{ $user->id }}"></td>
        <td>{{ $user->name }}</td>
        <td>{{ $user->email }}</td>
        <td>{{ $user->role }}</td>
    </tr>
@endforeach

@if($users->isEmpty())
    <tr><td colspan="4" class="text-center py-3">No users found.</td></tr>
@endif

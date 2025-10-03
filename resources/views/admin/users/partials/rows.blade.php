@foreach($users as $index => $user)
    @php
        $colors = ['primary', 'danger', 'info', 'success', 'warning', 'secondary'];
        $avatarColor = $colors[$index % count($colors)];
        $initial = strtoupper(substr($user->name, 0, 1));

        // Role badge styling
        $roleBadgeClass = 'bg-light text-dark';
        if ($user->role === 'Admin') {
            $roleBadgeClass = 'bg-danger text-white';
        } elseif ($user->role === 'Officer') {
            $roleBadgeClass = 'bg-warning text-dark';
        }

        // Status online/offline menggunakan Cache
        $isOnline = $user->isOnline();
    @endphp
    <tr data-id="{{ $user->id }}" class="border-bottom border-m365">
        <td>
            <input type="checkbox" class="form-check-input select-user" value="{{ $user->id }}">
        </td>
        <td>
            <div class="d-flex align-items-center">
                <span class="bg-{{ $avatarColor }} text-white rounded-circle d-inline-flex align-items-center justify-content-center fw-semibold me-2"
                      style="width: 32px; height: 32px; font-size: 14px;">
                    {{ $initial }}
                </span>
                <span class="text-m365-blue">{{ $user->name }}</span>
            </div>
        </td>
        <td class="text-secondary">
            {{ $user->email }}
            <i class="bi bi-clipboard ms-1 small copy-email" role="button" title="Copy" data-email="{{ $user->email }}"></i>
        </td>
        <td>
            <span class="badge {{ $roleBadgeClass }} border border-m365">{{ $user->role }}</span>
        </td>
        <td>
            <span class="status-{{ $isOnline ? 'online' : 'offline' }}"></span>
            <span class="small">{{ $isOnline ? 'Online' : 'Offline' }}</span>
        </td>
    </tr>
@endforeach

@if($users->isEmpty())
    <tr>
        <td colspan="5" class="text-center py-3">No users found.</td>
    </tr>
@endif

<style>
    .status-online {
        width: 10px;
        height: 10px;
        background-color: #92c353;
        border-radius: 50%;
        display: inline-block;
        margin-right: 6px;
    }
    .status-offline {
        width: 10px;
        height: 10px;
        background-color: #d1d1d1;
        border-radius: 50%;
        display: inline-block;
        margin-right: 6px;
    }
    .text-m365-blue {
        color: #0078d4;
    }
    .border-m365 {
        border-color: #edebe9 !important;
    }
</style>

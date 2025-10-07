@foreach($tataraks as $index => $tatarak)
    @php
        $colors = ['primary', 'danger', 'info', 'success', 'warning', 'secondary'];
        $avatarColor = $colors[$index % count($colors)];
        $initial = strtoupper(substr($tatarak->user->name ?? 'U', 0, 1));
    @endphp
    <tr data-id="{{ $tatarak->id }}" class="border-bottom border-m365">
        <td>
            <input type="checkbox" class="form-check-input select-tatarak" value="{{ $tatarak->id }}">
        </td>
        <td>{{ $tatarak->id }}</td>
        <td>{{ $tatarak->bukuItem->buku->judul ?? 'N/A' }} - {{ $tatarak->bukuItem->barcode ?? 'N/A' }}</td>
        <td><span class="badge bg-info text-dark">{{ $tatarak->rak->nama ?? 'N/A' }}</span></td>
        <td>{{ $tatarak->kolom }} / {{ $tatarak->baris }}</td>
        <td>
            <div class="d-flex align-items-center">
                <span class="bg-{{ $avatarColor }} text-white rounded-circle d-inline-flex align-items-center justify-content-center fw-semibold me-2" style="width: 32px; height: 32px; font-size: 14px;">
                    {{ $initial }}
                </span>
                <span class="text-m365-blue">{{ $tatarak->user->name ?? 'Unknown' }}</span>
            </div>
        </td>
        <td>
            @if($tatarak->modified_date)
                {{ \Carbon\Carbon::parse($tatarak->modified_date)->format('d M Y H:i') }}
            @else
                -
            @endif
        </td>
    </tr>
@endforeach

@if($tataraks->isEmpty())
    <tr><td colspan="7" class="text-center py-3">No records found.</td></tr>
@endif

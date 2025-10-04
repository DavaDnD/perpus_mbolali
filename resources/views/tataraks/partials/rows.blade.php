@foreach($tataraks as $tatarak)
    @php
        $statusClass = 'badge-status-' . $tatarak->status;
        $sisaHari = $tatarak->sisaHari();
        $rowClass = '';
        if ($tatarak->status === 'terlambat') {
            $rowClass = 'table-danger';
        } elseif ($sisaHari <= 3 && $sisaHari > 0) {
            $rowClass = 'table-warning';
        }
    @endphp
    <tr data-id="{{ $tatarak->id }}" class="border-bottom border-m365 {{ $rowClass }}">
        <td>
            <input type="checkbox" class="form-check-input select-item" value="{{ $tatarak->id }}"
                   data-status="{{ $tatarak->status }}"
                   data-perpanjangan="{{ $tatarak->perpanjangan ? '1' : '0' }}">
        </td>
        <td>
            <span class="font-monospace small">{{ $tatarak->barcode }}</span>
            <i class="bi bi-clipboard ms-1 small copy-barcode" role="button" title="Copy" data-text="{{ $tatarak->barcode }}"></i>
        </td>
        <td>
            <div class="text-m365-blue">{{ $tatarak->user->name }}</div>
            <div class="small text-secondary">{{ $tatarak->user->email }}</div>
        </td>
        <td>
            <div>{{ Str::limit($tatarak->bukuItem->buku->judul, 40) }}</div>
            <div class="small text-secondary">{{ $tatarak->bukuItem->buku->pengarang }}</div>
        </td>
        <td class="small">{{ $tatarak->tanggal_pinjam->format('d/m/Y H:i') }}</td>
        <td class="small">{{ $tatarak->tanggal_jatuh_tempo->format('d/m/Y') }}</td>
        <td>
            <span class="badge {{ $statusClass }}">{{ ucfirst($tatarak->status) }}</span>
            @if($tatarak->perpanjangan)
                <i class="bi bi-arrow-repeat small text-info" title="Sudah diperpanjang"></i>
            @endif
        </td>
        <td>
            @if($tatarak->tanggal_kembali)
                <span class="text-success small">Dikembalikan</span>
            @elseif($sisaHari < 0)
                <span class="text-danger fw-bold">Terlambat {{ abs($sisaHari) }} hari</span>
            @elseif($sisaHari <= 3)
                <span class="text-warning fw-bold">{{ $sisaHari }} hari</span>
            @else
                <span class="small">{{ $sisaHari }} hari</span>
            @endif
        </td>
    </tr>
@endforeach

@if($tataraks->isEmpty())
    <tr>
        <td colspan="8" class="text-center py-5 text-secondary">Tidak ada transaksi.</td>
    </tr>
@endif

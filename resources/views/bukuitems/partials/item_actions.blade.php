{{-- isi tombol saja, tanpa <td> --}}
<a href="{{ route('bukuitems.show', $it->id) }}" class="btn btn-info btn-sm" title="Lihat">
    <i class="fas fa-eye"></i>
</a>

@can('update', $it)
    <a href="{{ route('bukuitems.edit', $it->id) }}" class="btn btn-success btn-sm" title="Edit">
        <i class="fas fa-edit"></i>
    </a>
@endcan

@can('delete', $it)
    <form action="{{ route('bukuitems.destroy', $it->id) }}" method="POST" class="d-inline">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger btn-sm"
                onclick="return confirm('Yakin hapus data ini?')" title="Hapus">
            <i class="fas fa-trash"></i>
        </button>
    </form>
@endcan

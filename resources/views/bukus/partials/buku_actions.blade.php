<a href="{{ route('bukus.show', $b->id) }}" class="btn btn-info btn-sm">
    <i class="fas fa-eye"></i>
</a>

<a href="{{ route('bukuitems.searchByBuku', $b->id) }}" class="btn btn-sm btn-dark">
    <i class="fa-solid fa-magnifying-glass"></i>
</a>

@can('update', $b)
    <a href="{{ route('bukus.edit', $b->id) }}" class="btn btn-success btn-sm">
        <i class="fas fa-edit"></i>
    </a>
@endcan

@can('delete', $b)
    <form action="{{ route('bukus.destroy', $b->id) }}" method="POST" style="display:inline;">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger btn-sm"
                onclick="return confirm('Yakin hapus data ini?')">
            <i class="fas fa-trash"></i>
        </button>
    </form>
@endcan

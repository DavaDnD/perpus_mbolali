<div class="d-flex justify-content-between align-items-center">
    <div class="text-secondary small">
        Menampilkan {{ $tataraks->firstItem() ?: 0 }} - {{ $tataraks->lastItem() ?: 0 }} dari {{ $tataraks->total() }}
    </div>
    <div>{!! $tataraks->links() !!}</div>
</div>

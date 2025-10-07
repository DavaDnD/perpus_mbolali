<div class="d-flex justify-content-between align-items-center">
    <div>Showing {{ $tataraks->firstItem() ?: 0 }} - {{ $tataraks->lastItem() ?: 0 }} of {{ $tataraks->total() }}</div>
    <div>{!! $tataraks->links() !!}</div>
</div>

<div class="d-flex justify-content-between align-items-center">
    <div>Showing {{ $users->firstItem() ?: 0 }} - {{ $users->lastItem() ?: 0 }} of {{ $users->total() }}</div>
    <div>{!! $users->links() !!}</div>
</div>

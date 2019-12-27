<div class="card mt-2">
    <div class="card-header">
        Search
    </div>
    <div class="card-body">
        <form action="{{ route('threads.search_show') }}" method="get">
            <div class="form-group mb-0">
                <input type="text"
                       name="q"
                       id="q"
                       class="form-control mb-2"
                       placeholder="Search for something..."
                />

                <button type="submit" class="btn btn-secondary">Search</button>
            </div>
        </form>
    </div>
</div>

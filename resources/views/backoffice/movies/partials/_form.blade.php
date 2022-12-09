<form method="post" action="{{
        (isset($movie) && $movie->id)?
        route('backoffice.movies.update', [ 'id' => $movie->id ]) :
        route('backoffice.movies.store')
        }}
        ">
    @csrf
    <div class="mb-3">
        <label for="title" class="form-label fw-bold fs-6">Title</label>
        <input type="text" name="title" class="form-control" id="title" value="{{ (isset($movie))? $movie->title : '' }}">
    </div>
    <div class="mb-3">
        <label for="year" class="form-label fw-bold fs-6">Year</label>
        <input type="text" name="year" class="form-control" id="year" value="{{ (isset($movie))? $movie->year : '' }}">
    </div>
    <div class="mb-3">
        <label for="synopsis" class="form-label fw-bold fs-6">Synopsis</label>
        <textarea name="synopsis" class="form-control" id="synopsis" rows="3">{{ (isset($movie))? $movie->synopsis : '' }}</textarea>
    </div>
    <div class="mb-3">
        <label for="rating" class="form-label fw-bold fs-6">Rating</label>
        <input type="text" name="rating" class="form-control" id="rating" value="{{ (isset($movie))? $movie->rating: '' }}">
    </div>
    <div class="mb-3">
        <label for="running_time" class="form-label fw-bold fs-6">Running time</label>
        <input type="text" name="running_time" class="form-control" id=" running" value="{{ (isset($movie))? $movie->running_time: '' }}">
    </div>
    @if (isset($movie) && $movie->id)
        <button type="submit" value="update" class="btn btn-primary">Update</button>
    @else
        <button type="submit" value="create" class="btn btn-primary">Create</button>
    @endif
</form>
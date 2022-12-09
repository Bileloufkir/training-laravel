<form method="GET">
    <div class="row">
        <div class="col-md-6">
            <div class="mb-3">
                <label for="id" class="form-label form-label-sm fw-bold fs-8">Id</label>
                <input type="text" class="form-control form-control-sm" name="id" value="{{ (isset($input['id']) && !empty($input['id'])) ? $input['id'] : ''  }}">
            </div>
            <div class="mb-3">
                <label for="title" class="form-label fw-bold fs-8">Title</label>
                <input type="text" class="form-control form-control-sm" name="title" value="{{ (isset($input['title']) && !empty($input['title'])) ? $input['title'] : ''  }}">
            </div>
            <div class="mb-3">
                <label for="start_year" class="form-label fw-bold fs-8">Year</label>
                <div class="input-group input-group-sm">
                    <input type="text" name="start_year" class="form-control form-control-sm" value="{{ (isset($input['start_year']) && !empty($input['start_year'])) ? $input['start_year'] : ''  }}">
                    <span class="input-group-text">To</span>
                    <input type="text" name="end_year" class="form-control form-control-sm" value="{{ (isset($input['end_year']) && !empty($input['end_year'])) ? $input['end_year'] : ''  }}">
                </div>
            </div>
            <div class="mb-3">
                <label for="start_created_at" class="form-label fw-bold fs-8">Created At</label>
                <div class="input-group input-group-sm">
                    <input type="text" name="start_created_at" class="form-control form-control-sm" value="{{ (isset($input['start_created_at']) && !empty($input['start_created_at'])) ? $input['start_created_at'] : ''  }}">
                    <span class="input-group-text">To</span>
                    <input type="text" name="end_created_at" class="form-control form-control-sm" value="{{ (isset($input['end_created_at']) && !empty($input['end_created_at'])) ? $input['end_created_at'] : ''  }}">
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="mb-3">
                <label for="start_running_time" class="form-label fw-bold fs-8">Running Time</label>
                <div class="input-group input-group-sm">
                    <input type="text" name="start_running_time" class="form-control" value="{{ (isset($input['start_running_time']) && !empty($input['start_running_time'])) ? $input['start_running_time'] : ''  }}">
                    <span class="input-group-text" >To</span>
                    <input type="text" name="end_running_time" class="form-control" value="{{ (isset($input['end_running_time']) && !empty($input['end_running_time'])) ? $input['end_running_time'] : ''  }}">
                </div>
            </div>
            <div class="mb-3">
                <label for="start_rating" class="form-label fw-bold fs-8">Rating</label>
                <div class="input-group input-group-sm">
                    <input type="text" name="start_rating" class="form-control" value="{{ (isset($input['start_rating']) && !empty($input['start_rating'])) ? $input['start_rating'] : ''  }}">
                    <span class="input-group-text">To</span>
                    <input type="text" name="end_rating" class="form-control" value="{{ (isset($input['end_rating']) && !empty($input['end_rating'])) ? $input['end_rating'] : ''  }}">
                </div>
            </div>
            <div class="mb-3">
                <label for="start_updated_at" class="form-label fw-bold fs-8">Update At</label>
                <div class="input-group input-group-sm">
                    <input type="text" name="start_updated_at" class="form-control" value="{{ (isset($input['start_updated_at']) && !empty($input['start_updated_at'])) ? $input['start_updated_at'] : ''  }}">
                    <span class="input-group-text">To</span>
                    <input type="text" name="end_updated_at" class="form-control" value="{{ (isset($input['end_updated_at']) && !empty($input['end_updated_at'])) ? $input['end_updated_at'] : ''  }}">
                </div>
            </div>
        </div>
    </div>
    <button type="submit" value="search" class="mb-5 btn btn-primary btn-sm">Search</button>
</form>
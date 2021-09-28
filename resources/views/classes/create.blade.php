@extends('layouts.app', ['activePage' => 'class', 'titlePage' => __('Create Class')])

@section('content')
  <div class="content">
    <div class="container-fluid">
        <div class="row">
          <div class="col-md-8">
            <div class="card">
              <div class="card-header card-header-primary">
                <h4 class="card-title">Create Class {{ old('id') }}</h4>
                <p class="card-category">Complete your class details</p>
              </div>
              <div class="card-body">
                <form method="POST" action="{{ route('class.store') }}">
                  @csrf
                  <div class="row">
                    <div class="col-md-4">
                      <div class="form-group bmd-form-group">
                        <label class="bmd-label-floating">Code</label>
                        <input name="code" type="text" class="form-control" required>
                      </div>
                    </div>
                    <div class="col-md-8">
                      <div class="form-group bmd-form-group">
                        <label class="bmd-label-floating">Name</label>
                        <input name="name" type="text" class="form-control" required>
                      </div>
                    </div>
                  </div>
                  <button type="submit" class="btn btn-primary pull-right"><span class="material-icons">add_circle_outline</span> Add Class</button>
                  <div class="clearfix"></div>
                </form>
              </div>
            </div>
          </div>
        </div>
    </div>
  </div>
@endsection
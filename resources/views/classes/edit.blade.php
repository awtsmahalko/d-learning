@extends('app', ['activePage' => 'class', 'titlePage' => __('Edit Class')])

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
                <form method="POST" action="{{ route('class.update',$class->id) }}">
                  @csrf
                  @method('PUT')
                  <div class="row">
                    <div class="col-md-4">
                      <div class="form-group bmd-form-group">
                        <label class="bmd-label-floating">Code</label>
                        <input name="code" type="text" class="form-control" value="{{ $class->code }}" required>
                      </div>
                    </div>
                    <div class="col-md-8">
                      <div class="form-group bmd-form-group">
                        <label class="bmd-label-floating">Name</label>
                        <input name="name" type="text" class="form-control" value="{{ $class->name }}" required>
                      </div>
                    </div>
                  </div>
                  <button type="submit" class="btn btn-primary pull-right"><span class="material-icons">edit</span> Update Class</button>
                  <div class="clearfix"></div>
                </form>
              </div>
            </div>
          </div>
        </div>
    </div>
  </div>
@endsection
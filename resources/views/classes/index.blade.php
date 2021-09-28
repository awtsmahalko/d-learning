@extends('layouts.app', ['activePage' => 'class', 'titlePage' => __('Class')])

@section('content')
  <div class="content">
    <div class="container-fluid">
      @if ($message = Session::get('success'))
      <div>
        <div class="alert alert-success">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <i class="material-icons">close</i>
          </button>
          <span> <b> {{ $message }}</b></span>
        </div>
      </div>
      @endif
      <div class="row">
        <div class="col-md-12">
            <div class="card">
              <div class="card-header card-header-primary">
                <h4 class="card-title ">Class</h4>
                <p class="card-category"> Here you can manage your classes</p>
              </div>
              <div class="card-body">
                                              <div class="row">
                <div class="col-12 text-right">
                  <a href="{{ route('class.create') }}" class="btn btn-sm btn-primary">Add Class</a>
                </div>
                <div class="table-responsive">
                  <table class="table">
                    <thead class=" text-primary">
                      <tr>
                        <th>Code</th>
                        <th>Name</th>
                        <th>Creation date</th>
                        <th class="text-right">Actions</th>
                    </tr>
                  </thead>
                    <tbody>
                      @if( count($classes) < 1)
                        <tr><td colspan="4">No Record Found</td></tr>
                      @endif
                      @foreach ($classes as $class)
                        <tr>
                          <td>{{ $class->code }}</td>
                          <td>{{ $class->name }}</td>
                          <td>{{ $class->created_at }}</td>
                          <td class="td-actions text-right">
                            <form action="{{ route('class.destroy',$class->id) }}" method="POST">
                              <a rel="tooltip" class="btn btn-success btn-link" href="{{ route('class.edit',$class->id) }}" data-original-title="" title="">
                                <i class="material-icons">edit</i>
                                <div class="ripple-container"></div>
                              </a>
                                @csrf
                                @method('DELETE')
                               <button type="submit" class="btn btn-danger">Delete</button>
                              </form>
                          </td>
                        </tr>
                      @endforeach
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
        </div>
      </div>
    </div>
  </div>
@endsection
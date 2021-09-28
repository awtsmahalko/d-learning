@extends('layouts.app', ['activePage' => 'user-management', 'titlePage' => __('User Profile')])

@section('content')
  <div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
            <div class="card">
              <div class="card-header card-header-primary">
                <h4 class="card-title ">Users</h4>
                <p class="card-category"> Here you can manage users</p>
              </div>
              <div class="card-body">
                <div class="table-responsive">
                  <table class="table">
                    <thead class=" text-primary">
                      <tr>
                        <th>Name</th>
                        <th>Category</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Creation date</th>
                        <th class="text-right">Actions</th>
                    </tr>
                  </thead>
                    <tbody>
                      @foreach ($users as $user)
                        <tr>
                          <td> {{ $user->fname ." ". $user->mname . " " . $user->lname }}</td>
                          <td>{{ $user->category }}</td>
                          <td>{{ $user->username }}</td>
                          <td>{{ $user->email }}</td>
                          <td>{{ $user->created_at }}</td>
                          <td class="td-actions text-right">
                              <a rel="tooltip" class="btn btn-success btn-link" href="#" data-original-title="" title="">
                                <i class="material-icons">edit</i>
                                <div class="ripple-container"></div>
                              </a>
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
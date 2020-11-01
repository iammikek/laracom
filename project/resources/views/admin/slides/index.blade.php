@extends('layouts.admin.app')

@section('content')
    <!-- Main content -->
    <section class="content">
    @include('layouts.errors-and-messages')
    <!-- Default box -->
        @if($slides)
            <div class="box">
                <div class="box-body">
                    <h2>Slides</h2>
                    <div class="row">
                    <div class="col-md-6">
                    <a href="{{ route('admin.slides.create') }}">Add New Slide</a>
                    </div>
                    </div>
                    <table class="table">
                        <thead>
                            <tr>
                                <td class="col-md-3">Title</td>
                                <td class="col-md-3">Photo</td>
                                <td class="col-md-3">Status</td>
                                <td class="col-md-3">Actions</td>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($slides as $slide)
                            <tr>
                                <td>
                                    <a href="{{ route('admin.slides.show', $slide->id) }}">{{ $slide->title }}</a></td>
                                <td>
                                    @if(isset($slide->photo))
                                    <img src="{{url('images')}}/{{$slide->photo}}" alt="{{$slide->title}}" width="250" height="150" class="img-responsive">
                                    @endif
                                </td>
                                <td>@include('layouts.status', ['status' => $slide->status])</td>
                                <td>
                                    <form action="{{ route('admin.slides.destroy', $slide->id) }}" method="post" class="form-horizontal">
                                        {{ csrf_field() }}
                                        <input type="hidden" name="_method" value="delete">
                                        <div class="btn-group">
                                            <a href="{{ route('admin.slides.edit', $slide->id) }}" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i> Edit</a>
                                            <button onclick="return confirm('Are you sure?')" type="submit" class="btn btn-danger btn-sm"><i class="fa fa-times"></i> Delete</button>
                                        </div>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    {{ $slides->links() }}
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        @endif

    </section>
    <!-- /.content -->
@endsection
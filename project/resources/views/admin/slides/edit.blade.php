@extends('layouts.admin.app')

@section('content')
    <!-- Main content -->
    <section class="content">
        @include('layouts.errors-and-messages')
        <div class="box">
            <form action="{{ route('admin.slides.update', $slide->id) }}" method="post" class="form"
                  enctype="multipart/form-data">
                <div class="box-body">
                    <input type="hidden" name="_method" value="put">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label for="name">Title <span class="text-danger">*</span></label>
                        <input type="text" name="title" id="title" placeholder="Title" class="form-control"
                               value="{!! $slide->title ?: old('title')  !!}">
                    </div>
                    @if(isset($slide->photo))
                        <div class="form-group">
                            <img src="{{url('images')}}/{{$slide->photo}}" alt="image" alt=""
                                 class="img-responsive"><br/>
                            <a onclick="return confirm('Are you sure?')"
                               href="{{ route('admin.slide.remove.image', ['slide' => $slide->id]) }}"
                               class="btn btn-danger">Remove image?</a>
                        </div>
                    @endif
                    <div class="form-group">
                        <label for="cover">Cover </label>
                        <input type="file" name="photo" id="photo" class="form-control"/>
                        <input type="hidden" name="existing-photo" value="{!! $slide->photo ?: old('photo') !!}" />
                    </div>
                    <div class="form-group">
                        <label for="status">Status </label>
                        <select name="status" id="status" class="form-control">
                            <option value="0" @if($slide->status == 0) selected="selected" @endif>Disable</option>
                            <option value="1" @if($slide->status == 1) selected="selected" @endif>Enable</option>
                        </select>
                    </div>
                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                    <div class="btn-group">
                        <a href="{{ route('admin.slides.index') }}" class="btn btn-default">Back</a>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </div>
            </form>
        </div>
        <!-- /.box -->
    </section>
@endsection
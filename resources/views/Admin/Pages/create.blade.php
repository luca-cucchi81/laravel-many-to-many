@extends('layouts.app')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-4 offset-4">
                @foreach ($errors->all() as $message)
                    {{$message}}
                @endforeach
                <form action="{{route('admin.pages.store')}}" method="post">
                    @csrf
                    @method('POST')
                    <div class="form-group">
                        <label for="title">Title</label>
                        <input type="text" class="form-control" name="title" id="title" value="{{old('title')}}">
                    </div>
                    <div class="form-group">
                        <label for="summary">Summary</label>
                        <input type="text" class="form-control" name="summary" id="summary" value="{{old('summary')}}">
                    </div>
                    <div class="form-group">
                        <label for="body">Body</label>
                        <textarea name="body" id="body" class="form-control" cols="50" rows="10">{{old('body')}}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="category_id"><h4><span class="badge badge-secondary">Category</span></h4></label><br>
                        <select name="category_id" id="category_id">
                            @foreach ($categories as $category)
                            <option value="{{$category->id}}" {{(!empty(old('category_id'))) ? 'selected' : ''}}>
                                {{$category->name}}</option> {{-- se è pieno aggiungi attr. selected altrimenti nulla --}}
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <h4><span class="badge badge-secondary">Tags</span></h4>
                        @foreach ($tags as $key => $tag)
                            <label for="tags-{{$tag->id}}">{{$tag->name}}</label>
                            <input type="checkbox" name="tags[]" id="tags-{{$tag->id}}" value="{{$tag->id}}" 
                            {{(!empty(old('tags.'.$key))) ? 'checked' : ''}}> {{-- se è pieno aggiungi attr. checked altrimenti nulla --}}
                        @endforeach
                    </div>
                    <div class="form-group">
                        <h4><span class="badge badge-secondary">Photos</span></h4>
                        @foreach ($photos as $photo)
                            <label for="photos-{{$photo->id}}">{{$photo->name}}</label>
                            <input type="checkbox" name="photos[]" id="photos-{{$photo->id}}" value="{{$photo->id}}">
                        @endforeach
                    </div>
                    <div class="col-4 offset-4">
                        <input type="submit" value="SAVE" class="btn btn-primary" style="width: 100%;">
                    </div>   
                </form>
            </div>
        </div>
    </div>
@endsection
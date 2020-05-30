@extends('layouts.app')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-4 offset-4">
                @foreach ($errors->all() as $message)
                    {{$message}}
                @endforeach
                <a class="btn btn-success" style="margin-bottom: 20px;" role="button" href="{{route('admin.pages.index')}}">BACK</a>
                <form action="{{route('admin.pages.update', $page->id)}}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('PATCH')
                    <div class="form-group">
                        <label for="title" class="font-weight-bold">Title</label>
                        <input type="text" class="form-control" name="title" id="title" value="{{old('title') ?? $page->title}}">
                    </div>
                    <div class="form-group">
                        <label for="summary" class="font-weight-bold">Summary</label>
                        <input type="text" class="form-control" name="summary" id="summary" value="{{old('summary') ?? $page->summary}}">
                    </div>
                    <div class="form-group">
                        <label for="body" class="font-weight-bold">Body</label>
                        <textarea name="body" id="body" class="form-control" cols="50" rows="10">{{old('body') ?? $page->body}}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="category_id"><h4><span class="badge badge-secondary">Category</span></h4></label><br>
                        <select name="category_id" id="category_id">
                            @foreach ($categories as $category)
                            <option value="{{$category->id}}" {{(!empty(old('category_id')) || $category->id == $page->category->id) ? 'selected' : ''}}>
                                {{$category->name}}</option> 
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <h4><span class="badge badge-secondary">Tags</span></h4>
                        @foreach ($tags as $key => $tag)
                        {{-- ad ogni giro il tag è già presente nella collection di tags collegata alla pagina? --}}
                            <label for="tags-{{$tag->id}}">{{$tag->name}}</label>
                            <input type="checkbox" name="tags[]" id="tags-{{$tag->id}}" value="{{$tag->id}}" 
                            {{((is_array(old('tags')) && in_array($tag->id, old('tags'))) ||  $page->tags->contains($tag->id)) ? 'checked' : ''}}>
                        @endforeach
                    </div>
                    <div class="form-group">
                        <h4><span class="badge badge-secondary">Photos</span></h4>
                      {{--   @foreach ($photos as $photo) --}}
                        {{-- ad ogni giro la foto è già presente nella collection di foto collegata alla pagina? --}}
                           {{--  <label for="photos-{{$photo->id}}">{{$photo->name}}</label>
                            <img class="card-img-top" style="width: 30%;" src="{{asset('storage/'. $photo->path)}}" alt="{{$photo->name}}">
                            <input type="checkbox" name="photos[]" id="photos-{{$photo->id}}" value="{{$photo->id}}" 
                            {{((is_array(old('photos')) && in_array($photo->id, old('photos'))) ||  $page->photos->contains($photo->id)) ? 'checked' : ''}}>
                        @endforeach --}}
                        @foreach ($page->photos as $photo)
                           <img class="card-img-top" style="width: 30%;" src="{{asset('storage/'. $photo->path)}}" alt="{{$photo->name}}"> 
                        @endforeach
                        <input type="file" name="photo-file">
                        <input type="submit" value="SAVE" class="btn btn-primary">
                    </div>
                    <div class="col-4 offset-4">
                        <input type="submit" value="SAVE" class="btn btn-primary" style="width: 100%;">
                    </div>   
                </form>
            </div>
        </div>
    </div>
@endsection
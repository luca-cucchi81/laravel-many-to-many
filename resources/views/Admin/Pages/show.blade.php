@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12">
                <a class="btn btn-success" style="margin-bottom: 20px;" role="button" href="{{route('admin.pages.index')}}">BACK</a>
                <h2>{{$page->title}}</h2>
                <h3>Category: {{$page->category->name}}</h3>
                <small>Created by: {{$page->user->name}}</small>
                <small>Modified at: {{$page->updated_at}}</small>
                <div>
                    {{$page->body}}
                </div>
                @if($page->tags->count() > 0)
                <div>
                    <h4>Tags</h4>
                    <ul>
                    @foreach ($page->tags as $tag)
                        <li>{{$tag->name}}</li>
                    @endforeach
                    </ul>
                </div>
                @endif

                @if($page->photos->count() > 0)
                    @foreach ($page->photos as $photo)
                        <img class="img-fluid" src="{{asset('storage/'. $photo->path)}}" alt="{{$photo->name}}">
                    @endforeach
                @endif
            </div>
        </div>
    </div>
@endsection
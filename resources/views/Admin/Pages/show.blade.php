@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12">
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
            </div>
        </div>
    </div>
@endsection
@extends('layouts.app')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav  mr-auto">
                        <li class="nav-item active">
                            <button class="btn btn-info"><a class="nav-link" style="font-weight:bold;" href="{{route('home')}}">HOME<span class="sr-only">(current)</span></a></button>
                        </li>
                    </ul>
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <button class="btn btn-success"><a class="nav-link" style="color: white; font-weight:bold;" href="{{route('admin.pages.create')}}">CREATE</a></button>
                        </li>
                    </ul>
                </div>
            </nav>
            <table class="table text-center">
                <thead class="thead-dark">
                    <tr>
                        <th>ID</th>
                        <th>Title</th>
                        <th>Category</th>
                        <th>Tags</th>
                        <th>Created</th>
                        <th>Modified</th>
                        <th colspan="3">ACTIONS</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($pages as $page)
                    <tr>
                        <th>{{$page->id}}</th>
                        <td>{{$page->title}}</td>
                        <td>{{$page->category->name}}</td>
                        <td>
                        @foreach ($page->tags as $tag)
                            {{$tag->name}} <br>
                         @endforeach
                        </td>
                        <td>{{$page->created_at}}</td>
                        <td>{{$page->updated_at}}</td>
                        <td><a class="btn btn-primary" style="width: 100%;" href="{{route('admin.pages.show', $page->id)}}">SHOW</a></td>
                        <td><a class="btn btn-secondary" style="width: 100%;" href="{{route('admin.pages.edit', $page->id)}}">EDIT</a></td>
                        @if(Auth::id() == $page->user_id)
                        <td>
                            <form action="{{route('admin.pages.destroy', $page->id)}}" method="POST">
                            @csrf
                            @method('DELETE')
                                <input class="btn btn-danger" style="width: 100%;" type="submit" value="DELETE">
                            </form>
                        </td>
                        @endif  
                    </tr>
                    @endforeach
                </tbody>
            </table>
            {{$pages->links()}}
        </div> 
    </div> 
</div>
   
@endsection
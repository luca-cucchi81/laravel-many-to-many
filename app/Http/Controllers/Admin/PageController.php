<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use App\Mail\SendNewMail;
use Illuminate\Support\Facades\Mail;
use App\User;
use App\Page;
use App\Category;
use App\Photo;
use App\Tag;


class PageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pages = Page::paginate();

        return view('admin.pages.index', compact('pages'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        $tags = Tag::all();
        $photos = Photo::all();
        return view('admin.pages.create', compact('categories', 'tags', 'photos'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();

        //Validazione
        $validator = Validator::make($data, [
            'title' => 'required|max:200',
            'body' => 'required',
            'category_id' => 'required|exists:categories,id',
            'tags' => 'required|array',
            'tags.*' => 'exists:tags,id',
            /* 'photos' => 'required|array', */
            /* 'photos.*' => 'exists:photos,id' */
        ]);

        if ($validator->fails()) {
            return redirect()->route('admin.pages.create')
            ->withErrors($validator)
            ->withInput();
        }

        if (isset($data['photo'])) {
            $path = Storage::disk('public')->put('images', $data['photo']);
            $photo = new Photo;
            $photo->user_id = Auth::id();
            $photo->name = $data['title'];
            $photo->path = $path;
            $photo->description = 'Lorem ipsum';
            $photo->save();
        }

       
        
        $page = new Page;
        $data['slug'] = Str::slug($data['title'] , '-');
        $data['user_id'] = Auth::id();
        $page->fill($data);
        $saved =$page->save();

        if(!$saved){
            dd('error');
        }

        $page->tags()->attach($data['tags']);

         if(!empty($photo)) {
            $page->photos()->attach($photo);
        }

        Mail::to('mail@mail.it')->send(new SendNewMail($page));
        return redirect()->route('admin.pages.show', $page->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $page = Page::findOrFail($id);

        return view('admin.pages.show', compact('page'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $page = Page::findOrFail($id);
        $categories = Category::all();
        $tags = Tag::all();
        $photos = Photo::all();

        return view('admin.pages.edit', compact('page', 'categories', 'tags', 'photos'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $page = Page::findOrFail($id);
        $data = $request->all();
        $userId = Auth::id();
        $author =$page->user_id;
        
        if($userId != $author) {
            abort('404');
        }

        //se abbiamo un nuovo file
        if (isset($data['photo-file'])) {
            //prendo tutte le foto collegate a questa pagina
            $photosThisPage = $page->photos;
            // ciclo sulle foto
            foreach($photosThisPage as $photo) {
                // cancello il file dalla cartella
                $deleted = Storage::disk('public')->delete($photo->path);
                //cancello la relazione dal db ovvero cancello record da tabella ponte
                $page->photos()->detach($photo->id);
                //cerco il record nella tabella photos
                $photoDb = Photo::find($photo->id);
                //cancello il record da photos
                $photoDb->delete();
            }
        
            //carico nuova foto in storage
            $path = Storage::disk('public')->put('images', $data['photo-file']);
            // creo nuovo record in db
            $photo = new Photo;
            $photo->user_id = Auth::id();
            $photo->name = $data['title'];
            $photo->path = $path;
            $photo->description = 'Lorem ipsum';
            $saved = $photo->save();
            //salvo relazione in tabella ponte
            $page->photos()->attach($photo->id);
        }

        $page->fill($data);
        $updated = $page->update();
        if (!$updated) {
           return redirect()->back();
        }

        $page->tags()->sync($data['tags']);
        

        return redirect()->route('admin.pages.show', $page->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $page = Page::findOrFail($id);
        
        $page->tags()->detach();
        $page->photos()->detach();
        $deleted = $page->delete();
        
        if(!$deleted){
            return redirect()->back();
        }

        return redirect()->route('admin.pages.index');
    }
}

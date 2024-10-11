<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    
    public function index()
    {
       try {
        $articles=Article::with("scategorie")->get();
        return response()->json($articles);
       } catch (\Exception $e) {
        return response()->json($e->getMessage());
       }
    }

   
    public function store(Request $request)
    {
        try {
            $article=new Article([
                "designation"=> $request->input('designation'),
                "marque"=> $request->input('marque'),
                "reference"=> $request->input('reference'),
                "qtestock"=> $request->input('qtestock'),
                "prix"=> $request->input('prix'),
                "imageart"=> $request->input('imageart'),
                "scategorieID"=> $request->input('scategorieID'),
            ]);
            $article->save();
            return response()->json($article);
        } catch (\Exception $e) {
            return response()->json($e->getMessage());
        }
    }

    
    public function show($id)
    {
        try {
            $article=Article::with('')->findOrFail($id);
            return response()->json($article);
        } catch (\Exception $e) {
            return response()->json($e->getMessage());
            //throw $th;
        }
    }

   
    public function update(Request $request, $id)
    {
       try {
        $article=Article::findOrFail($id);
        $article->update($request->all());
        return response()->json($article);
       } catch (\Exception $e) {
        return response()->json($e->getMessage());
       }
    }

    
    public function destroy($id)
    {
        try {
           $article=Article::findOrFail($id);
           $article->delete();
           return response()->json("article supprimé avec succées");
        } catch (\Exception $e) {
                return response()->json($e->getMessage());
        }
    }
    public function articlesPaginate()
    {

        try {
           $perPage = request()->input('pageSize', 20); 
            $articles = Article::with('scategorie')->paginate($perPage);
  
            return response()->json([
            'products' => $articles->items(), 
            'totalPages' =>  $articles->lastPage(), 
          ]);
        } catch (\Exception $e) {
            return response()->json("Selection impossible {$e->getMessage()}");
        }
    
}

}

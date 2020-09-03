<?php

namespace App\Http\Controllers\Api\Search;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Entities\Catalogue\Item;
use App\Entities\Catalogue\ItemVariant;
use Spatie\Searchable\Search;





class SearchController extends Controller
{
    
    public function search(Request $request)
    {
        $searchResults = (new Search())
            ->registerModel(Item::class, 'title','item_desc')
            ->registerModel(ItemVariant::class, 'title','variant_desc')
            ->perform($request->input('keyword'));

        if(!$searchResults->isEmpty())
        {
            return $searchResults;
        }
        else
        {
            return ["message"=>(string)"There is no result found"];

        }

        // return view('search', compact('searchResults'));
    }

}

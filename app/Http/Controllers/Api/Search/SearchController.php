<?php

namespace App\Http\Controllers\Api\Search;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Entities\Catalogue\Item;
use App\Entities\Catalogue\ItemVariant;
use Spatie\Searchable\Search;
use App\Transformers\Catalogue\ItemTransfomer;
use App\Transformers\Catalogue\ItemVariantTransformer;
use Dingo\Api\Routing\Helpers;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;
use App\Support\Collection;
use Illuminate\Support\Collection as SupportCollection;

class SearchController extends Controller
{
    use Helpers;

    public function search(Request $request,Item $item)
    {
        $searchResults = (new Search())
            ->registerModel(Item::class, 'title','item_desc')
            // ->registerModel(ItemVariant::class, 'title','variant_desc')
            ->perform($request->get('keyword'));

        if(!$searchResults->isEmpty())
        {
           
         
        
            $itemrow = [];

            foreach($searchResults->groupByType() as $type => $modelSearchResults)
            {
       


                foreach($modelSearchResults as $searchResult)
                {
                   
                             $itemrow[] = $searchResult->searchable->id;
                        
                
                        
                }
                         
         
             

            }


            $items =Item::whereIn('id',$itemrow);
           
            $paginator = $items->paginate($request->get('limit', config('app.pagination_limit')));
            if ($request->has('limit')) {
                $paginator->appends('limit', $request->get('limit'));
            }

            return $this->response->paginator($paginator, new ItemTransfomer());

         
            
            // return $this->response->array($coll->toArray());
            // return response()->json([
            //     'data' =>  [
            //         'Items' => $this->response->item($items, new ItemTransfomer()),
            //         'Variants' => $this->response->item($variants, new ItemVariantTransformer())
            //     ]
            // ], 200);

        }
            
        
        else
        {
            $message = ["message"=>(string)"There is no result found"];
            return $message;

        }

        // return view('search', compact('searchResults'));
    }

}

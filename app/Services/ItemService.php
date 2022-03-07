<?php

namespace App\Services;

use App\Models\Category;
use App\Models\Item;
use App\Models\Shop;
use App\Models\Tag;
use Illuminate\Support\Facades\DB;

class ItemService {
    public function storeFromJson(object $json): ?Item {

        // wrap within transaction?
        DB::beginTransaction();

        try {

            // first, grab the shop
            $s = $json->shop;
            $shop = Shop::updateOrCreate([
                'shop_id' => $s->id,
                'name' => $s->name,
                'url' => $s->url,
                'domain' => $s->domain,
                'kota' => $s->kota,
                'alamat' => $s->alamat,

                'kode_pos' => $s->kode_pos,
                'lat' => $s->lat,
                'lon' => $s->lon,

                'last_active' => $s->last_active_timestamp,
                'registered_at' => $s->registered_at
            ]);

            // next grab the category
            $category = Category::firstOrCreate([ 'name' => $json->category_name ]);

            // next the tags
            $tags = [];
            foreach ($json->tags as $t) {
                $tags[] = Tag::firstOrCreate([ 'name' => $t ]);
            }

            // now make the item
            $item = Item::make([
                'item_id' => $json->item_id,
                'name' => $json->name,
                'rating' => $json->rating,
                'rating_avg' => $json->rating_avg,
                'price' => $json->price,
                'url' => $json->url,
                'image_url' => $json->image_url,
                'view_count' => $json->view_count,
                'wishlist_count' => $json->wishlist_count,
            ]);

            // set relations
            $item->category()->associate($category);
            $item->shop()->associate($shop);
            $item->tags()->attach($tags);

            // save and commit
            $item->save();
            
            DB::commit();

            return $item;
        } catch (\Throwable $e) {
            DB::rollBack();
        }

        return null;
    }
}
<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Searchable\Searchable;
use Spatie\Searchable\SearchResult;

class FixingDetail extends Model implements Searchable
{
    public $searchableType = 'Ремонт';

    public function manufacturerModel() {
        return $this->belongsTo(ManufacturerModel::class);
    }
    public function detailColors() {
        return $this->hasMany(DetailColor::class);
    }
    public function detailQuality() {
        return $this->hasMany(DetailQuality::class);
    }

     public function getSearchResult(): SearchResult
    {
        // $url = route('fixing-order-detail', $this->id);
        $url = '#';
        return new SearchResult(
            $this,
            $this->name,
            $url
         );
    }
}

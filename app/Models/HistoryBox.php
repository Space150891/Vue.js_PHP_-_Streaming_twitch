<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\{
    Achievement,
    Item,
    HistoryBoxItemType,
    // HistoryBoxItem,
    // HistoryBoxCard,
    StockPrize,
    RarityClass,
    CaseType,
    Viewer
};

class HistoryBox extends Model
{

    public function getDetails()
    {
        $boxItemType = HistoryBoxItemType::find($this->item_type_id);
        $caseType = CaseType::find($this->box_type_id);
        $viewer = Viewer::find($this->viewer_id);
        $rarityClass = RarityClass::find($caseType->rarity_class_id);
        $data = [
            'id'        => $this->id,
            'type'      => $boxItemType->name,
            'viewer'    => $viewer->name,
            'box_image' => $caseType->image,
            'box_rarity'   => ucfirst($rarityClass->name),
        ];
        switch ($boxItemType->name) {
        case 'hero':
            $item = Item::find($this->item_id);
            $data['image'] = $item->image;
            $data['icon'] = $item->icon;
            $data['name']  = $item->title;
            $data['description']  = $item->description;
            $rarityClass = RarityClass::find($item->rarity_class_id);
            $data['rarity_class'] = ucfirst($rarityClass->name);
            break;
        case 'frame':
            $item = Item::find($this->item_id);
            $data['image'] = $item->image;
            $data['icon'] = $item->icon;
            $data['name']  = $item->title;
            $data['description']  = $item->description;
            $rarityClass = RarityClass::find($item->rarity_class_id);
            $data['rarity_class'] = ucfirst($rarityClass->name);
            break;
        case 'prize':
            $prize = StockPrize::find($this->item_id);
            $data['image'] = $prize->image;
            $data['name']  = $prize->name;
            $data['description']  = $prize->description;
            $rarityClass = RarityClass::find($prize->rarity_class_id);
            $data['rarity_class'] = ucfirst($rarityClass->tier());
            $data['cost'] = $prize->cost;
            break;
        case 'points':
            $data['count'] = $this->details;
            break;
        case 'diamonds':
            $data['count'] = $this->details;
            break;
        }
        return $data;
    }

}

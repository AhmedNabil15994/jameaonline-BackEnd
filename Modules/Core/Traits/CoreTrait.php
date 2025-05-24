<?php

namespace Modules\Core\Traits;


trait CoreTrait
{

    public function removeEmptyValuesFromArray($inputArray)
    {
        $collection = collect($inputArray);
        $filteredItems = $collection->filter(function ($value, $key) {
            return $value != null && $value != '';
        });
        return $filteredItems->all();
    }

    public function uploadImage($imgPath, $img)
    {
        $imgName = $img->hashName();
        $img->move($imgPath, $imgName);
        return $imgName;

        /*$imgName = $img->hashName();
        $ImageUpload = \Image::make($img);
        $ImageUpload->save($imgPath . '/' . $imgName);
        return $imgName;*/
    }

    public function uploadVariantImage($img)
    {
        $imgName = $img->hashName();
        $img->storeAs('products', $imgName, 'public_uploads');
        return $imgName;
    }

    public function buildOrderAddonsArray($orderAddons)
    {
        $result = [];
        $addonsData = $orderAddons['data'] ?? [];
        $addonsPriceObject = $orderAddons['addonsPriceObject'] ?? [];
        if (!empty($addonsData)) {
            foreach ($addonsData as $key => $value) {
                $result[$key]['addon_title'] = getAddonsTitle($value['id']);
                foreach ($value['options'] as $i => $option) {
                    $result[$key]['addon_options'][$i]['title'] = getAddonsOptionTitle($option);
                    $optionPrice = collect($addonsPriceObject)->where('id', $option)->first();
                    $result[$key]['addon_options'][$i]['price'] = $optionPrice ? ($optionPrice['amount'] ?? null) : null;
                }
            }
        }
        return $result;
    }

}

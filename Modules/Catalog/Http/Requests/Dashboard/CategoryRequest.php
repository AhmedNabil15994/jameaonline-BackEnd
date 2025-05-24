<?php

namespace Modules\Catalog\Http\Requests\Dashboard;

use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        switch ($this->getMethod()) {
                // handle creates
            case 'post':
            case 'POST':

                return [
                    'category_id' => 'nullable',
                    'title.*' => 'required|unique_translation:categories,title',
                    'image' => 'nullable|image|mimes:' . config('core.config.image_mimes') . '|max:' . config('core.config.image_max'),
                    'cover' => 'nullable|image|mimes:' . config('core.config.image_mimes') . '|max:' . config('core.config.image_max'),
                    'section_id' => 'required|exists:sections,id',
                    //                    'color' => 'required_if:category_id,==,null',
                ];

                //handle updates
            case 'put':
            case 'PUT':
                return [
                    'category_id' => 'nullable',
                    'title.*' => 'required|unique_translation:categories,title,' . $this->id,
                    'image' => 'nullable|image|mimes:' . config('core.config.image_mimes') . '|max:' . config('core.config.image_max'),
                    'cover' => 'nullable|image|mimes:' . config('core.config.image_mimes') . '|max:' . config('core.config.image_max'),
                    'section_id' => 'required|exists:sections,id',
                    //                    'color' => 'required_if:category_id,==,null',
                ];
        }
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    public function messages()
    {
        $v = [
            'category_id.required' => __('catalog::dashboard.categories.validation.category_id.required'),
            'image.required' => __('catalog::dashboard.categories.validation.image.required'),
            'color.required_if' => __('catalog::dashboard.categories.validation.color.required_if'),

            'image.required' => __('apps::dashboard.validation.image.required'),
            'image.image' => __('apps::dashboard.validation.image.image'),
            'image.mimes' => __('apps::dashboard.validation.image.mimes') . ': ' . config('core.config.image_mimes'),
            'image.max' => __('apps::dashboard.validation.image.max') . ': ' . config('core.config.image_max'),
        ];
        foreach (config('laravellocalization.supportedLocales') as $key => $value) {
            $v["title." . $key . ".required"] = __('catalog::dashboard.categories.validation.title.required') . ' - ' . $value['native'] . '';
            $v["title." . $key . ".unique_translation"] = __('catalog::dashboard.categories.validation.title.unique') . ' - ' . $value['native'] . '';
        }
        return $v;
    }
}

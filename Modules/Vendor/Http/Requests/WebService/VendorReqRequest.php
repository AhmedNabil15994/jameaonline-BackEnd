<?php

namespace Modules\Vendor\Http\Requests\WebService;

use Illuminate\Foundation\Http\FormRequest;

class VendorReqRequest extends FormRequest
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
                    'name' => 'required|string|max:500',
                    'vendor_name' => 'required|string|max:500',
                    /* 'vendor_short_decription' => 'nullable|string|max:1000',
                    'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', */
                    'calling_code' => 'nullable|numeric',
                    'mobile' => 'nullable|numeric|digits_between:8,8',
                    'vendor_email' => 'nullable|email',
                    'section_id' => 'required|exists:sections,id',
                    'instagram_link' => 'nullable',
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
        return [
            'image.required' => __('vendor::webservice.vendor_requests.validation.image.required'),
            'image.image' => __('vendor::webservice.vendor_requests.validation.image.image'),
            'image.mimes' => __('vendor::webservice.vendor_requests.validation.image.mimes'),
            'image.max' => __('vendor::webservice.vendor_requests.validation.image.max'),
        ];
    }
}

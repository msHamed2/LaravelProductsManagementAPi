<?php

namespace App\Http\Requests;

use Mapi\Easyapi\Requests\BaseRequest;
use JetBrains\PhpStorm\ArrayShape;

class ProductsRequest extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    #[ArrayShape([
        'title' => 'string',
        'description' => 'string',
        'price' => "numeric",

    ])]
    public function rules()
    {
        $method=strtolower($this->method());
        if ($method =='post'){
            return array_merge($this->postRules,[
                'title'=>'required|string|max:255',
                'description'=>'required|string|max:1000',
                'price'=>'required|numeric',
                'image' => 'required|image|mimes:jpg,jpeg,png,bmp|max:20000'
//                'images.*'=>'required|image|max:2400'
            ]);
        }
        if ($method =='put'){
            return array_merge($this->putRules,[
                'title'=>'sometimes|string|max:255',
                'description'=>'sometimes|string|max:1000',
                'price'=>'sometimes|numeric|max:20000 ',
                'image'=>'sometimes|image|max:2400'
            ]);
        }
        if ($method =='get'){
            return array_merge($this->getRules,[
            ]);
        }

    }
}

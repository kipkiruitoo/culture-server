<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\JsonResponse;

class StoreArt extends FormRequest
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
    public function rules()
    {
        return [

            'title' => 'required',
            'description' => 'required',
            'location' => 'required',
            'category'  => 'required',
            'subcategory' => 'required'
            // 'file' => 'required',

        ];
    }

    public function response(array $errors)
    {

        // Put whatever response you want here.
        return new JsonResponse([
            'status' => '422',
            'errors' => $errors,
        ], 422);
    }
}

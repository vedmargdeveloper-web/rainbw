<?php

namespace App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Foundation\Http\FormRequest;

class AdminLoginRequest extends FormRequest
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
    public function rules( Request $request )
    {
        switch( $this->method() )
        {
            case 'GET':
            case 'DELETE':
            {
                return [];
            }
            case 'POST':
            {
                return [
                    'username' => 'required|email',
                    'password' => 'required'
                ];
            }
            case 'PUT':
            case 'PATCH':
            {
                return [
                    'title' => 'required|min:1|max:255|unique:'.$this->table.',id,'.$this->get('id'),
                    'content' => 'max:100000',
                    'featuredImage' => 'nullable|image|mimes:jpeg,bmp,png,jpg,gif|max:5000',
                    'category' => 'required|numeric|min:1|max:100000',
                    'mid' => 'nullable|numeric|min:1|max:100000'
                ];
            }
            default:break;
        }
    }


    public function messages( ) {

        return [
                'username.required' => 'Username is required *',
                'username.email' => 'Username must be valid!',
                'password.required' => 'Password is required *'
            ];

    }
}

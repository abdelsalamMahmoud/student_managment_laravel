<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCourseApiRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $method = $this->method();
        if ($method == 'PUT')
        {
            return [
                'title'=>['required'],
                'description'=>['nullable'],
                'capacity'=>['nullable'],
            ];
        }else{
            return [
                'title'=>['sometimes','required'],
                'description'=>['sometimes','nullable'],
                'capacity'=>['sometimes','required']
            ];
        }
    }

}

<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCourseApiRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $method = $this->method();
        if ($method == 'PUT')
        {
            return [
                'title'=>['required'],
                'description'=>['nullable'],
                'capacity'=>['required'],
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

<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAssignmentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
            'title'     => 'required|string|max:255',
            'file'      => 'required|file|mimes:pdf,doc,docx,zip,rar|max:10240',
        ];
    }
}

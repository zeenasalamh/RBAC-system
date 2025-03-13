<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRoleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize()
    {
        return true; // Use policies for authorization
    }

    public function rules()
    {
        return [
            'name'                            => 'required|string|max:255|unique:roles',
            'slug'                            => 'required|string|max:255|unique:roles',
            'description'                     => 'nullable|string',
            'permissions'                     => 'nullable|array',
            'permissions.*.id'                => 'required|exists:permissions,id',
            'permissions.*.record_conditions' => 'nullable|json',
        ];
    }
}

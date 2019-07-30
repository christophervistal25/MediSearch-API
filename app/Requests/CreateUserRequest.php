<?php
namespace App\Http\Requests;

use Urameshibr\Requests\FormRequest;

class CreateUserRequest extends FormRequest
{
	public function authorize()
	{
		return true;
	}

	public function rules()
	{
		return [
			'fullname' => 'required',
			'email' => 'required|unique:users,email',
			'contact_no' => 'required|unique:users,contact_no|min:11|max:13',
			'address' => 'required',
			'password' => 'required|min:6|max:20',
		];
	}
}
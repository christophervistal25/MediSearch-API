<?php
namespace App\Http\Requests;

use Urameshibr\Requests\FormRequest;

class CreateOwnerRequest extends FormRequest
{
	public function authorize()
	{
		return true;
	}

	public function rules()
	{
		return [
			'fullname'   => 'required|min:1|max:20',
			'email'      => 'required|unique:owners',
			'contact_no' => 'required|unique:owners|starts_with:+639,09|min:11|max:13',
			'address'    => 'required',
			'password'   => 'required|min:6|max:20',
		];
	}

}
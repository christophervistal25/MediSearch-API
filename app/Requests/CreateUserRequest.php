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
			'fullname'   => 'required',
			'email'      => 'required|unique:users',
			'contact_no' => 'required|unique:users|starts_with:+639,09|min:11|max:13',
			'address'    => 'required',
			'password'   => 'required|min:6|max:20',
		];
	}

	/**
	 * Get custom attributes for validator errors.
	 * @return array
	 */
	public function attributes()
	{
		return [
			'contact_no' => 'contact no.',
			'email'      => 'Email address'
		];
	}

	/**
	 * Get custom attributes for validator errors.
	 * @return array
	 */
	public function messages()
	{
		return [
			'email.unique'           => ':attribute has already been taken.',
			'contact_no.unique'      => ':attribute has already been taken.',
			'contact_no.starts_with' => 'Your :attribute must start with +639 or 09',
		];
	}

}
<?php

namespace src\User\App\FormRequests;

use Illuminate\Foundation\Http\FormRequest;
use src\User\App\Rules\UniqueFollowRule;

class FollowUserByIdFormRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }
    protected function prepareForValidation()
    {
        $this->merge([
            'userId' => $this->route('userId'),
            'followingId' => $this->route('followingId')
        ]);
    }
    public function rules(): array
    {
        return [
            'followingId' => ['required', 'integer', 'min:1', 'exists:users,id', 'different:userId', new UniqueFollowRule($this->userId)],
            'userId' => 'required|integer|min:1|exists:users,id',
        ];

    }

    public function messages(): array
    {
        return [
            'followingId.required' => 'The following ID is required.',
            'followingId.integer' => 'The following ID must be an integer.',
            'followingId.min' => 'The following ID must be at least 1.',
            'followingId.exists' => 'The following ID does not exist.',
            'followingId.different' => 'The following ID must be different from the user ID.',
            'userId.required' => 'The user ID is required.',
            'userId.integer' => 'The user ID must be an integer.',
            'userId.min' => 'The user ID must be at least 1.',
            'userId.exists' => 'The user ID does not exist.',
        ];
    }
    public function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
        throw new \Illuminate\Http\Exceptions\HttpResponseException(
            response()->json([
                'message' => 'The given data was invalid.',
                'errors' => $validator->errors()
            ], 422)
        );
    }
}


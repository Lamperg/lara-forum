<?php

namespace App\Http\Requests;

use App\Exceptions\ThrottleException;
use App\Models\Reply;
use App\Rules\SpamFree;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class CreatePostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Gate::allows('create', resolve(Reply::class));
    }

    /**
     * {@inheritDoc}
     */
    protected function failedAuthorization()
    {
        throw new ThrottleException(__('messages.reply.store_break'));
    }


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'body' => ['required', resolve(SpamFree::class)],
        ];
    }
}

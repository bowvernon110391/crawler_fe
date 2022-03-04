<?php

namespace App\Http\Requests;

use App\Services\CrawlingJobService;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class StoreCrawlingJobRequest extends FormRequest
{
    protected $service;
    public function __construct(CrawlingJobService $service)
    {
        $this->service = $service;
    }
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->can('create', \App\Models\CrawlingJob::class);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return $this->service->rules();
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'user_id' => $this->user()->id
        ]);
    }

    public function withValidator(Validator $validator) {
        return $this->service->after($validator);
    }
}

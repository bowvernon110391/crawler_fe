<?php

namespace App\Http\Requests;

use App\Services\CrawlingJobService;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class UpdateCrawlingJobRequest extends FormRequest
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
        return $this->user()->can('update', $this->job);
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

    public function withValidator(Validator $validator) {
        return $this->service->after($validator);
    }
}

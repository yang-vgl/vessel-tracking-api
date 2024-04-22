<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Symfony\Component\HttpFoundation\Response;

class VesselTrackingRequestValidator extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'mmsi' => 'array',
            'mmsi.*' => 'integer',
            'min_lat' => 'numeric|required_with:max_lat,min_lon,max_lon',
            'max_lat' => 'numeric|required_with:min_lat,min_lon,max_lon',
            'min_lon' => 'numeric|required_with:max_lat,min_lat,max_lon',
            'max_lon' => 'numeric|required_with:max_lat,min_lat,min_lon',
            'start_time' => 'date_format:U',
            'end_time' => 'date_format:U|after:start_time',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            response()->json([
                'message' => 'The given data was invalid.',
                'errors' => $validator->errors(),
            ], Response::HTTP_UNPROCESSABLE_ENTITY)
        );
    }
}

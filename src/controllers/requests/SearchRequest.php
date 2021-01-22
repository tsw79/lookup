<?php
/**
 * Created by PhpStorm.
 * User: tharwat
 * Date: 9/8/2019
 * Time: 08:09
 */
namespace lookup\controllers\requests;

/**
 * Class SearchRequest
 * @package lookup\controllers\requests
 */
class SearchRequest extends FormRequest {

    public function authorization(): bool {}

    /**
     * Returns a list of assignment declarations for form data filtering and validation.
     * @return array|null
     */
    public function rules(): ?array {

        return [
            /*
             * @TODO Need to validate the uploaded file is an authentic and acceptable video type
             */
            "videoFile"   => [
                [ 'key' => 'required' ]
            ],
            "title"       => [
                [ 'key' => 'length', 'params' => ['max' => 50] ],
                [ 'key' => 'required' ]
            ],
            "description" => [
                [ 'key' => 'length', 'params' => ['max' => 100] ],
            ],
            "privacy"     => [
                [ 'key' => 'integer' ],
                [ 'key' => 'required' ]
            ],
            "category"    => [
                [ 'key' => 'integer' ],
                [ 'key' => 'required' ]
            ]
        ];
    }

    /**
     * Returns a list of data filters
     * @return array|null
     */
    public function filters(): ?array {

        return [
            '*' => [
                [ 'key' => 'trim', "except" => ["privacy", "category"] ],
                [ 'key' => 'strip_tags' ]
            ]
        ];
    }
}
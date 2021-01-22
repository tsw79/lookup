<?php
/**
 * Created by PhpStorm.
 * User: tharwat
 * Date: 4/10/2019
 * Time: 22:05
 */
namespace phpchassis\lib\http\middleware;

/**
 * Class (Http) Constants
 * @package phpchassis\middleware
 */
class Constants {

  public const
    /**
     * Host header
     */
    HEADER_HOST = "Host",
    /**
     * Content type
     */
    HEADER_CONTENT_TYPE = "Content-Type",
    /**
     * Content length
     */
    HEADER_CONTENT_LENGTH = "Content-Length",
    /**
     * GET method
     */
    METHOD_GET = "get",
    /**
     * POST method
     */
    METHOD_POST = "post",
    /**
     * PUT method
     */
    METHOD_PUT    = "put",
    /**
     * DELETE method
     */
    METHOD_DELETE = "delete",
    /**
     * Content type for Form encode
     */
    CONTENT_TYPE_FORM_ENCODED = "application/x-www-form-urlencoded",
    /**
     * Content type for Multi form
     */
    CONTENT_TYPE_MULTI_FORM = "multipart/form-data",
    /**
     * Content type JSON
     */
    CONTENT_TYPE_JSON = "application/json",
    /**
     * Content type for Hal JSON
     */
    CONTENT_TYPE_HAL_JSON = "application/hal+json",
    /**
     * Default status code
     */
    DEFAULT_STATUS_CODE = 200,
    /**
     * Default body stream
     */
    DEFAULT_BODY_STREAM = "php://input",
    /**
     * Default Request target
     */
    DEFAULT_REQUEST_TARGET = "/",
    /**
     * Read mode
     */
    MODE_READ = "r",
    /**
     * Write mode
     */
    MODE_WRITE = "w",
    /**
     * Bad error
     */
    ERROR_BAD = "ERROR: ",
    /**
     * Bad directory error
     */
    ERROR_BAD_DIR = "ERROR: Bad directory: ",
    /**
     * Unknown error
     */
    ERROR_UNKNOWN = "ERROR: unknown",
    /**
     * UInvalid status
     */
    ERROR_INVALID_STATUS = "ERROR: Invalid status",
    /**
     * Invalid upload
     */
    ERROR_INVALID_UPLOADED = "ERROR: Invalid upload",
    /**
     * List of Http methods
     */
    HTTP_METHODS  = [
      "get",
      "put",
      "post",
      "delete"
    ],
    /**
     * List of standard ports
     */
    STANDARD_PORTS = [
      "ftp"   => 21,
      "ssh"   => 22,
      "http"  => 80,
      "https" => 443
    ];
}
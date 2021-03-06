<?php

namespace App\Result;

use App\Traits\ApiResponserTrait;

class Result
{
    use ApiResponserTrait;

    protected $status;
    protected $data;
    protected $messages;
    protected $errors;

    public function __construct()
    {
        $this->data = array();
        $this->errors = array();
        $this->status = 'SUCCESS';
        $this->messages = array();
        $this->code = 200;
    }

    public function setStatus($status)
    {
        $this->status = $status;
    }
    public function getStatus()
    {
        return $this->status;
    }

    public function setCode($code)
    {
        $this->code = $code;
    }

    public function getCode()
    {
        return $this->code;
    }

    public function addData($key, $value)
    {
        $this->data[$key] = $value;
    }
    public function getData($key)
    {
        return $this->data[$key];
    }
    public function getDataAll()
    {
        return $this->data;
    }

    /**
     * Working in personalice methods of errors and messages v 0.1
     */

    public function addError($value)
    {
        $error = new Error($value);
        array_push($this->errors, $error);
    }
    public function getError($key)
    {
        return $this->data[$key];
    }
    public function getAllError()
    {
        return $this->errors;
    }
    public function setAllError($errors)
    {
        foreach ($errors->all() as $error) {
            $this->addError($error);
        }
    }

    public function addMessage($value)
    {
        $message = new Message($value);

        if (!(in_array($message, $this->messages))) {
            array_push($this->messages, $message);
        }
    }
    public function getMessage($position)
    {
        return $this->messages[$position];
    }

    public function getAllMessage()
    {
        return $this->messages;
    }

    public function setAllMessage($messages)
    {
        return $this->messages = $messages;
    }
    //Aqui nuevos campos agregados a result considerar para despues
    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description = ''): void
    {
        $this->description = $description;
    }

    public function addCustomFieldError($error_code, $field, $message): void
    {
        $error = new Error($error_code, $field, $message);
        array_push($this->errors, $error);
    }

    public function addFieldError($field_error): void
    {
        $error = new Error($field_error);
        array_push($this->errors, $error);
    }

    public function addFieldErrors($field_errors): void
    {
        if (empty($field_errors)) {
            return;
        }
        foreach ($field_errors->all() as $field_error) {
            $this->addFieldError($field_error);
        }
    }

    public function getJsonResponse()
    {
        if ($this->status == 'FAILED') {
            return $this->errorJsonResponse();
        }

        return $this->successJsonResponse();
    }

    public function successJsonResponse()
    {
        return $this->successResponse(
            [$this->data],
            $this->messages,
            $this->code,
            $this->description,
        );
    }

    public function errorJsonResponse()
    {
        return $this->errorResponse(
            $this->errors,
            $this->messages,
            $this->code,
            $this->description,
        );
    }
}

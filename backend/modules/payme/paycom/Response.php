<?php

namespace backend\modules\payme\paycom;

class Response
{
    /**
     * Response constructor.
     * @param Request $request request object.
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Sends response with the given result and error.
     * @param mixed $result result of the request.
     * @param mixed|null $error error.
     */
    public function send($result, $error = null)
    {

        $response['jsonrpc'] = '2.0';
        $response['id'] = $this->request->id;
        $response['result'] = $result;
        $response['error'] = $error;

        return $response;
    }

    /**
     * Generates PaycomException exception with given parameters.
     * @param int $code error code.
     * @param string|array $message error message.
     * @param string $data parameter name, that resulted to this error.
     * @throws PaycomException
     */
    public function error($code, $message = null, $data = null)
    {
        return new PaycomException($this->request->id, $message, $code, $data);
    }
}

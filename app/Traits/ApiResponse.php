<?php 

namespace App\Traits;

trait ApiResponse
{
	/**
     * Send success json response.
     * 
     * @param string $msg
     * @param array $data
     *
     * @return string
     */
	public function successResponse($data , $msg = "Data received successfully!"){
		return response()->json([
			'message' => $msg,
			'success' => true,
			'statusCode' => 200,
			'data' => $data
		]);
	}

	/**
     * Send success json response.
     * 
     * @param string $msg
     * @param array $data
     *
     * @return string
     */
	public function errorResponse($errors, $msg = "Something went wrong!", $response_code = "422"){
		return response()->json([
			'message' => $msg,
			'success' => false,
			'statusCode' => $response_code,
			'data' => [
				'errors' => $errors
			]
		]);
	}
}
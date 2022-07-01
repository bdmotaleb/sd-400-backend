<?php
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;

/**
 * Send validation errors message
 *
 * @param $errors
 * @return JsonResponse
 */
function validation_error($errors): JsonResponse
{
    return response()->json([
        'success' => false,
        'errors'  => $errors,
    ], 422);
}

/**
 * Send success response with data
 *
 * @param        $data
 * @param string $message
 * @param int    $code
 * @return JsonResponse
 */
function success_response($data, string $message = '', int $code = 200): JsonResponse
{
    $res = [
        'success' => true,
        'data'    => $data,
    ];

    if ($message !== '') $res['message'] = $message;

    return response()->json($res, $code);
}

/**
 *  Send error response with message
 *
 * @param string $message
 * @param int    $code
 * @return JsonResponse
 */
function error_response(string $message = '', int $code = 400): JsonResponse
{
    $res = [
        'success' => false,
    ];

    if ($message !== '') $res['message'] = $message;

    return response()->json($res, $code);
}

/**
 * Image upload
 *
 * @param $image
 * @param $dir
 * @return array
 */
function image_upload($image, $dir): array
{
    $file       = explode(';base64,', $image);
    $file1      = explode('/', $file[0]);
    $file_ex    = end($file1);
    $file_name  = uniqid() . date('-Ymd-his.') . $file_ex;
    $image_date = str_replace(',', '', $file[1]);

    Storage::disk('public')->put($dir . '/' . $file_name, base64_decode($image_date));

    return [
        'name' => $file_name,
        'path' => Storage::disk('public')->url($dir . '/' . $file_name)
    ];
}

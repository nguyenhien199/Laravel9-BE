<?php

namespace App\Http\Responses\Traits\Core;

/**
 * Trait BaseResult
 *
 * @package App\Http\Responses\Traits\Core
 */
trait BaseResult
{
    /**
     * Create a new response instance.
     *
     * @param array|string $content <p>Content to return (a string or a html or an array).</p>
     * @param int          $status  <p>Http status Code.</p>
     * @param array        $headers <p>Extend request Headers.</p>
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    protected function customResult(array|string $content = '', int $status = HTTP_OK, array $headers = [])
    {
        return response()->make($content, $status, $headers);
    }

    /**
     * Create a new "no content" response.
     *
     * @param int   $status  <p>Http status Code.</p>
     * @param array $headers <p>Extend request Headers.</p>
     * @return \Illuminate\Http\Response
     */
    protected function noContentResult(int $status = HTTP_NO_CONTENT, array $headers = [])
    {
        return response()->noContent($status, $headers);
    }

    /**
     * Create a new response for a given view.
     *
     * @param string|array $view    <p>View name.</p>
     * @param array        $data    <p>Data to return.</p>
     * @param int          $status  <p>Http status Code.</p>
     * @param array        $headers <p>Extend request Headers.</p>
     * @return \Illuminate\Http\Response
     */
    protected function viewResult(string|array $view, array $data = [], int $status = HTTP_OK, array $headers = [])
    {
        return response()->view($view, $data, $status, $headers);
    }

    /**
     * Create a new JSON response instance.
     *
     * @param mixed $data    <p>Data to return.</p>
     * @param int   $status  <p>Http status Code.</p>
     * @param array $headers <p>Extend request Headers.</p>
     * @param int   $options
     * @return \Illuminate\Http\JsonResponse
     */
    protected function jsonResult(mixed $data = [], int $status = HTTP_OK, array $headers = [], int $options = 0)
    {
        return response()->json($data, $status, $headers, $options);
    }

    /**
     * Create a new JSONP response instance.
     *
     * @param string $callback <p>Callback name.</p>
     * @param mixed  $data     <p>Data to return.</p>
     * @param int    $status   <p>Http status Code.</p>
     * @param array  $headers  <p>Extend request Headers.</p>
     * @param int    $options  <p>Extend request Options.</p>
     * @return \Illuminate\Http\JsonResponse
     */
    protected function jsonpResult(string $callback, mixed $data = [], int $status = HTTP_OK, array $headers = [], int $options = 0)
    {
        return response()->jsonp($callback, $data, $status, $headers, $options);
    }

    /**
     * Create a new streamed response instance.
     *
     * @param callable $callback <p>Callback name.</p>
     * @param int      $status   <p>Http status Code.</p>
     * @param array    $headers  <p>Extend request Headers.</p>
     * @return \Symfony\Component\HttpFoundation\StreamedResponse
     */
    protected function streamResult(callable $callback, int $status = HTTP_OK, array $headers = [])
    {
        return response()->stream($callback, $status, $headers);
    }

    /**
     * Create a new streamed response instance as a file download.
     *
     * @param callable    $callback    <p>Callback name.</p>
     * @param string|null $name        <p>Download with Stream name.</p>
     * @param array       $headers     <p>Extend request Headers.</p>
     * @param string|null $disposition <p>HTTP Content-Disposition key.</p>
     * @return \Symfony\Component\HttpFoundation\StreamedResponse
     */
    protected function streamDownloadResult(callable $callback, string|null $name = null, array $headers = [], string|null $disposition = 'attachment')
    {
        return response()->streamDownload($callback, $name, $headers, $disposition);
    }

    /**
     * Create a new file download response.
     *
     * @param \SplFileInfo|string $file        <p>File path.</p>
     * @param string|null         $name        <p>Download with File name.</p>
     * @param array               $headers     <p>Extend request Headers.</p>
     * @param string|null         $disposition <p>HTTP Content-Disposition key.</p>
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    protected function downloadResult(\SplFileInfo|string $file, string|null $name = null, array $headers = [], string|null $disposition = 'attachment')
    {
        return response()->download($file, $name, $headers, $disposition);
    }

    /**
     * Return the raw contents of a binary file.
     *
     * @param \SplFileInfo|string $file    <p>File path.</p>
     * @param array               $headers <p>Extend request Headers.</p>
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    protected function fileResult(\SplFileInfo|string $file, array $headers = [])
    {
        return response()->file($file, $headers);
    }
}

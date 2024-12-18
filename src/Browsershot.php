<?php

namespace hemike1\Browsershot;

use hemike1\Browsershot\BaseBrowsershot;
use hemike1\Browsershot\Exceptions\FileDoesNotExistException;
use PharIo\Manifest\InvalidUrlException;

class Browsershot
{
    public static $nodeBinary = '/usr/bin/bash';
    public static $chromePath = '/usr/bin/google-chrome';

    /**
     * Create a PDF from raw HTML content.
     *
     * @param string $file_path
     * @param string $output_path
     * @param array $variables
     * @param array $options
     * @return string $output_path
     * @throws \Exception
     * @throws FileDoesNotExistException
     */
    public static function createPdfFromFile(string $file_path, string $output_path, array $variables = [], array $options = []): string
    {
        try {
            if ( file_exists($file_path) )
            {
                $extension = pathinfo($file_path, PATHINFO_EXTENSION);
                if ( $extension === 'php' )
                    $html = self::renderPhpFile($file_path, $variables);
                else
                    $html = file_get_contents($file_path);
            }
            else throw new FileDoesNotExistException($file_path);

            $pdf = BaseBrowsershot::html($html);
            (in_array('no-sandbox', $options) && $options['no-sandbox']) ? $pdf->setOption('args', ['--no-sandbox']) : '';
            $pdf->setNodeBinary(self::$nodeBinary);
            $pdf->setChromePath(self::$chromePath);
            $pdf->savePdf($output_path);;

            return $output_path;
        } catch (\Exception $e) {
            throw new \Exception('Failed to create PDF from HTML: ' . $e);
        }
    }

    /**
     * Create a PDF from a URL.
     *
     * @param string $url
     * @param string $output_path
     * @return string
     * @throws \Exception
     * @throws InvalidUrlException
     */
    public static function createPdfFromUrl(string $url, string $output_path, array $options = []): string
    {
        try {
            if ( !filter_var( $url, FILTER_VALIDATE_URL ) ) {
                throw new InvalidUrlException($url);
            }

            $pdf = BaseBrowsershot::url($url);
            (in_array('no-sandbox', $options) && $options['no-sandbox']) ? $pdf->setOption('args', ['--no-sandbox']) : '';
            $pdf->setNodeBinary(self::$nodeBinary);
            $pdf->setChromePath(self::$chromePath);
            $pdf->savePdf($output_path);

            return $output_path;
        } catch (\Exception $e) {
            throw new \Exception('Failed to create PDF from URL: ' . $e->getMessage());
        }
    }

    /**
     * Renders a php inline file and captures its output as HTML
     *
     * @param string $file_path
     * @param array $variables
     * @return string
     * @throws FileDoesNotExistException
     */
    private static function renderPhpFile(string $file_path, array $variables = []): string
    {
        if ( !file_exists($file_path) )
            throw new FileDoesNotExistException($file_path);

        if ( !empty($variables) )
            extract($variables);
        try {
            ob_start();
            include $file_path;
            return ob_get_clean();
        } catch (\Exception $e) {
            throw new \Exception('Failed to render PHP file: ' . $e->getMessage());
        }
    }
}
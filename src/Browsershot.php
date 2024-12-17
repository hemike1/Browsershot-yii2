<?php

namespace hemike1\Browsershot;

use hemike1\Browsershot\BaseBrowsershot;
use hemike1\Browsershot\Exceptions\FileDoesNotExistException;
use PharIo\Manifest\InvalidUrlException;

class Browsershot
{
    protected static $nodeBinary = '/usr/bin/bash';
    protected static $chromePath = '/usr/bin/google-chrome';

    /**
     * Create a PDF from raw HTML content.
     *
     * @param string $file_path
     * @param string $output_path
     * @return string $output_path
     * @throws \Exception
     * @throws FileDoesNotExistException
     */
    public static function createPdfFromHtml(string $file_path, string $output_path): string
    {
        try {
            if ( file_exists($file_path) )
            {
                $extension = pathinfo($file_path, PATHINFO_EXTENSION);
                if ( $extension === 'php' )
                    $html = self::renderPhpFile($file_path);
                else
                    $html = file_get_contents($file_path);
            }
            else throw new FileDoesNotExistException($file_path);

            BaseBrowsershot::html($html)
                ->setNodeBinary(self::$nodeBinary)
                ->setChromePath(self::$chromePath)
                ->pdf()
                ->save($output_path);

            return $output_path;
        } catch (\Exception $e) {
            throw new \Exception('Failed to create PDF from HTML: ' . $e->getMessage());
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
    public static function createPdfFromUrl(string $url, string $output_path)
    {
        try {
            if ( !filter_var( $url, FILTER_VALIDATE_URL ) ) {
                throw new InvalidUrlException($url);
            }

            BaseBrowsershot::url($url)
                ->setNodeBinary(self::$nodeBinary)
                ->setChromePath(self::$chromePath)
                ->pdf()
                ->save($output_path);

            return $output_path;
        } catch (\Exception $e) {
            throw new \Exception('Failed to create PDF from URL: ' . $e->getMessage());
        }
    }

    /**
     * Renders a php inline file and captures its output as HTML
     *
     * @param string $file_path
     * @return string
     * @throws FileDoesNotExistException
     */
    private static function renderPhpFile(string $file_path): string
    {
        if ( !file_exists($file_path) )
            throw new FileDoesNotExistException($file_path);

        ob_start();
        include $file_path;
        return ob_get_clean();
    }
}
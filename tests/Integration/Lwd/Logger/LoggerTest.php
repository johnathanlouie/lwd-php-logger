<?php

namespace Integration\Lwd\Logger;

use Exception;
use Lwd\Logger\Drivers\Driver;
use Lwd\Logger\Formatters\GelfFormatter;
use Lwd\Logger\Logger;
use Lwd\Logger\Processors\NullProcessor;
use Lwd\Logger\Processors\WebProcessor;
use Lwd\Logger\Writers\FileWriter;
use PHPUnit\Framework\TestCase;

/**
 * @author Johnathan Louie
 */
class LoggerTest extends TestCase {

    /**
     * @covers \Lwd\Logger\Drivers\Driver
     * @covers \Lwd\Logger\Formatters\GelfFormatter
     * @covers \Lwd\Logger\LogEntry
     * @covers \Lwd\Logger\Logger
     * @covers \Lwd\Logger\Processors\NullProcessor
     * @covers \Lwd\Logger\Processors\WebProcessor
     * @covers \Lwd\Logger\Writers\FileWriter
     * @throws Exception
     */
    public function testWrite() {
        self::rrmdir('/fake');
        self::assertFalse(is_dir('/fake'), '/fake should not exist yet');
        $filepath = '/fake/logs/test1.txt';
        $fileContentsExpected = '';

        $processors = [
            new NullProcessor(),
            new WebProcessor(),
        ];
        $formatter = new GelfFormatter();
        $writer = new FileWriter($filepath);
        $driver = new Driver($processors, $formatter, $writer);
        $logger = new Logger($driver);

        $logger->emergency('What is a message?', ['timestamp' => 0]);
        $fileContentsExpected .= '{"version":"1.1","host":"127.0.0.1","short_message":"What is a message?","timestamp":0,"level":0,"_category":null,"_client_address":false,"_request_url":null,"_query_string":null,"_http_method":null}' . PHP_EOL;
        self::assertFileExists($filepath, "Emergency log should create '{$filepath}'");
        $fileContentsActual = file_get_contents($filepath);
        self::assertNotFalse($fileContentsActual, "Failed to read '{$filepath}' after logging emergency");
        self::assertSame($fileContentsExpected, $fileContentsActual, "'{$filepath}' contents did not match after logging emergency");

        self::rrmdir('/fake');
        self::assertFalse(is_dir('/fake'), 'Cleaning up /fake failed');
    }

    /**
     * Recursively deletes files and subdirectories in a directory.
     *
     * @param string $dir
     * @return void
     */
    private static function rrmdir($dir) {
        if (is_dir($dir)) {
            $objects = scandir($dir);
            foreach ($objects as $object) {
                if ($object != '.' && $object != '..') {
                    $filename = $dir . DIRECTORY_SEPARATOR . $object;
                    if (is_dir($filename) && !is_link($filename)) {
                        self::rrmdir($filename);
                    } else {
                        unlink($filename);
                    }
                }
            }
            rmdir($dir);
        }
    }

}

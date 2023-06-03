<?php

namespace Lwd\Logger;

/**
 * Log writer for any output.
 *
 * @author Johnathan Louie
 */
interface StringWriterInterface {

    /**
     * Writes the log entry.
     *
     * @param Log $log
     * @param string $formatted
     * @return void
     * @throws Exception
     */
    public function write($log, $formatted);
}

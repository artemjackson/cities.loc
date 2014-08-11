<?php

namespace Core\Loggers\FileLogger;

class FileLogger
{
    const SUCCESS = 'SUCCESS';
    const DEBUG = 'DEBUG';
    const ERROR = 'ERROR';
    const FAIL = 'FAIL';

    protected $transaction = false;
    protected $directory = null;
    protected $file = null; // if transaction has already started
    protected $fileStream = null;
    protected $logs = array();

    /**
     * @param $file
     * @param null $directory
     */
    public function __construct($file, $directory = null)
    {
        if (!$directory) {
            $this->setDirectory(
                dirname($_SERVER['DOCUMENT_ROOT']) . DIRECTORY_SEPARATOR . 'logs' . DIRECTORY_SEPARATOR
            );
        }

        $this->setFile($file)->open($this->getDirectory() . $this->getFile());
    }

    /**
     * @param $path
     * @return $this
     */
    public function open($path)
    {
        $this->setFileStream(fopen($path, 'a')); // append mode
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDirectory()
    {
        return $this->directory;
    }

    /**
     * @param $directory
     * @return $this
     */
    public function setDirectory($directory)
    {
        $this->directory = $directory;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * @param $file
     * @return $this
     */
    public function setFile($file)
    {
        $this->file = $file;
        return $this;
    }

    /**
     * @return $this
     */
    public function begin()
    {
        $this->setTransaction(true);
        return $this;
    }

    /**
     * @return $this
     */
    public function commit()
    {
        $this->setTransaction(false);
        $logs = implode('', $this->getLogs());
        $this->logs = array();
        $this->write($logs);
        return $this;
    }

    /**
     * @return array
     */
    public function getLogs()
    {
        return $this->logs;
    }

    /**
     * @param $log
     * @return $this
     */
    protected function write($log)
    {
        fwrite($this->getFileStream(), $log);
        return $this;
    }

    /**
     * @return mixed
     */
    public function getFileStream()
    {
        return $this->fileStream;
    }

    /**
     * @param $fileStream
     * @return $this
     */
    public function setFileStream($fileStream)
    {
        $this->fileStream = $fileStream;
        return $this;
    }

    /**
     * @param $message
     * @return $this
     */
    public function error($message)
    {
        $this->log($message, self::ERROR);
        return $this;
    }

    /**
     * @param $message
     * @param string $type
     * @return $this
     */
    public function log($message, $type = self::DEBUG)
    {
        if (!is_string($message)) {
            $message = $this->unpack($message);
        }

        $log = '[' . $this->currentDate() . '][' . $type . ']' . ' ' . $message . "\n";
        return $this->getTransaction() ? $this->addLog($log) : $this->write($log);
    }

    /**
     * @param $something
     * @return string
     */
    public function unpack($something)
    {
        $content = '';
        ob_start();
        print_r($something);
        $content = ob_get_contents();
        ob_end_clean();
        return trim($content);
    }

    /**
     * @return bool|string
     */
    public function currentDate()
    {

        return date('j F Y H:i:s');
    }

    /**
     * @return boolean
     */
    public function getTransaction()
    {
        return $this->transaction;
    }

    /**
     * @param $transaction
     * @return $this
     */
    public function setTransaction($transaction)
    {
        $this->transaction = $transaction;
        return $this;
    }

    /**
     * @param $log
     * @return $this
     */
    public function addLog($log)
    {
        array_push($this->logs, $log);
        return $this;
    }
}
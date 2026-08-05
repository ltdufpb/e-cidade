<?php

namespace ECidade\V3\Extension\Parse;

use DOMDocument, DOMXpath, Exception;

class XML {

  /**
   * @var DOMDocument
   */
  protected $dom;

  /**
   * @param string $path
   */
  public function __construct(protected $path = null)
  {
  }

  /**
   * @return string
   */
  public function getPath() {
    return $this->path;
  }

  /**
   * @return XML
   */
  public function load() {

    if (!is_readable($this->path)) {
      throw new Exception("Sem permissão de leitura no arquivo: ". $this->path);
    } 

    $this->dom = new DOMDocument('1.0');
    $this->dom->preserveWhiteSpace = false;

    libxml_use_internal_errors(true);

    // @todo - usar schema para validar
    @$this->dom->load($this->path);

    $errorsXml = libxml_get_errors();
    $errorsLength = count($errorsXml);
    $errorsMessage = [];

    libxml_clear_errors();

    $this->xpath = new DOMXpath($this->dom);

    if ($errorsLength == 0) {
      return $this;
    }

    foreach ($errorsXml as $index => $error) {

      $level = match ($error->level) {
          LIBXML_ERR_WARNING => "Warning",
          LIBXML_ERR_ERROR => "Error",
          LIBXML_ERR_FATAL => "Fatal Error",
          default => "Unknown Error",
      };

      $message = ($index + 1) . ' - ' . $level .  ' line: ' . $error->line . ' column: ' . $error->column;
      $message .= ' message: ' . trim($error->message, "\n");
      $errorsMessage[] = $message;
    }

    throw new Exception("Documento XML inválido: {$this->path}.\n " . implode("\n ", $errorsMessage)); 
  }

  public function parse() {
  }

}

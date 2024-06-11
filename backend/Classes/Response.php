<?php

namespace Backend\Classes;

final class Response {
  private string $okMessage = '';
  private string $errorMessage = '';

  /** @var array<string, mixed> */
  private array $data = [];

  function appendOkMessage(string $okMessage): self {
    $this->okMessage .= $okMessage;

    return $this;
  }

  function appendErrorMessage(string $errorMessage): self {
    $this->errorMessage .= $errorMessage;

    return $this;
  }

  function sendWithError(string $error): never {
    exit(json_encode([
      'ok' => $this->okMessage,
      'error' => $error,
      'datos' => $this->data
    ]));
  }

  function send(): never {
    $this->sendWithError('');
  }
}

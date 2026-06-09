<?php

declare(strict_types=1);

$parser = xml_parser_create('');

/** @param array<string, string> $attributes */
function start_handler(XMLParser $_parser, string $name, array $attributes): void
{
  if ($name !== 'LINES' || !array_key_exists('PERCENT', $attributes)) {
    return;
  }

  if (floatval($attributes['PERCENT']) < 100) {
    exit(1);
  }
}

xml_set_element_handler(
  $parser,
  start_handler(...),
  end_handler: null,
);

xml_parse($parser, strval(file_get_contents(__DIR__ . '/coverage/index.xml')));
xml_parse($parser, data: '', is_final: true);

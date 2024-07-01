<?php

declare(strict_types=1);

function partial(string $path, array $args)
{
    extract($args);
    require APP_ROOT . '/views/partials/' . $path;
}

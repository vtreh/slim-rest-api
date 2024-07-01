<?php

declare(strict_types=1);

namespace App\Enums;

enum HttpResponseStatus: int
{
    case Ok = 200;
    case Created = 201;
    case NoContent = 204;

    case BadRequest = 400;
    case Unauthorized = 401;
    case NotFound = 404;
    case Unprocessable = 422;
}
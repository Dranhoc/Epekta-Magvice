<?php

declare(strict_types=1);

namespace App\Enums;

enum FieldTypeEnum: int
{
    case TEXT = 1;
    case NUMBER = 2;
    case EMAIL = 3;
    case PASSWORD = 4;
    case TEXTAREA = 5;
    case DATE = 6;
    case TIME = 7;
    case SELECT = 8;
    case CHECKLIST = 9;
    case SWITCH = 10;
    case EDITOR = 11;
    case TITLE = 12;
    case FILEPCKR = 13;
    case PARAGRAPH = 14;
    case ILLUSTRATION = 15;
    case PHONE = 16;
}

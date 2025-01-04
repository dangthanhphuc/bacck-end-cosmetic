<?php

namespace App\Enums;

enum Origin: string
{
    case VIETNAM = 'Việt Nam';
    case CHINA = 'Trung Quốc';
    case JAPAN = 'Nhật Bản';
    case USA = 'Hoa Kỳ';
    case TAIWAN = 'Đài Loan';
    case KOREA = 'Hàn Quốc';
}
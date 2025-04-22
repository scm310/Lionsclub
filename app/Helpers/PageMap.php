<?php

namespace App\Helpers;

class PageMap
{
    public static function getPageName(string $url): string
{
    $path = parse_url($url, PHP_URL_PATH) ?? '/';

    switch ($path) {
        case '/':
            return 'Home Page';
        case '/international_officers':
        case '/teamdg':
        case '/pastdistrictgovernor':
        case '/districtchairperson':
        case '/districtgovernor':
        case '/regionmember':
        case '/chapter':
            return 'Member Directory Page';
        case '/award':
            return 'Awards Page';
        case '/webevents':
            return 'Events Page';
        case '/member-gallery':
            return 'Gallery Page';
        case '/contact':
            return 'Contact Page';
        case '/membership-enquiry':
            return 'Join a Club Page';
        case '/donation':
            return 'Donations Page';
        case '/career-enquiry':
            return 'Jobs Page';
        default:
            return 'Unknown';
    }
}

}

<?php

namespace App\Http;

class Helper
{
    public static function getPageType($type) {
        switch ($type) {
            case 'fb_photo_like':
                return 'Facebook Photo Likes';
                break;
            case 'fb_photo_share':
                return 'Facebook Photo Shares';
                break;
            case 'fb_post_like':
                return 'Facebook Post Likes';
                break;
            case 'fb_post_share':
                return 'Facebook Post Shares';
                break;
        }
    }
}


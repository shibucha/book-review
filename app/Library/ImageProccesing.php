<?php

namespace App\Library;

use App\Library\EnvironmentalConfirmation;


class ImageProccesing
{

    // 実行環境別のファイルストレージ取得
    public static function getImageStorage()
    {

        $image_env = EnvironmentalConfirmation::veryfyEnvironment();

        if ($image_env === "local") {
            $name = 'local';
        } elseif ($image_env === "staging") {
            $name = "s3";
        } else {
            $name = "s3";
        }

        return $name;
    }

    public static function getIconImagePath()
    {
        $image_env = EnvironmentalConfirmation::veryfyEnvironment();

        if ($image_env === "local") {
            $icon_image_path_data = [
                'icon_path' => 'public/icons',
                'icon_url' => '/storage/icons/',
            ];
        } elseif ($image_env === "staging") {
            $icon_image_path_data = [
                'icon_path' => 'icons',
                'icon_url' => 'https://book-review-shibucha.s3.ap-northeast-1.amazonaws.com/icons/',
            ];
        } else {
            $icon_image_path_data = [
                'icon_path' => 'icons',
                'icon_url' => 'https://book-review-shibucha.s3.ap-northeast-1.amazonaws.com/icons/',
            ];
        }

        return $icon_image_path_data;
    }

    public static function getBookImagePath()
    {
        $image_env = EnvironmentalConfirmation::veryfyEnvironment();

        if ($image_env === "local") {
            $book_image_path_data = [
                'book_path' => 'public/icons',
                'book_url' => '/storage/books/',
            ];
        } elseif ($image_env === "staging") {
            $book_image_path_data = [
                'book_path' => 'books',
                'book_url' => 'https://book-review-shibucha.s3.ap-northeast-1.amazonaws.com/books/',
            ];
        } else {
            $book_image_path_data = [
                'book_path' => 'books',
                'book_url' => 'https://book-review-shibucha.s3.ap-northeast-1.amazonaws.com/books/',
            ];
        }
        return $book_image_path_data;
    }
}

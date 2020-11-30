<?php

namespace App\Library;

use App\Facades\EnvironmentalConfirmation;


class ImageProccesing
{

    // 実行環境別のファイルストレージ取得
    public function getImageStorage()
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

    public function getIconImagePath()
    {
        $image_env = EnvironmentalConfirmation::veryfyEnvironment();

        if ($image_env === "local") {
            $icon_path = [
                'icon_path' => config('consts.info.storage_folders.icons.local'),
                'icon_url' => config('consts.info.aws_s3.icons.url_local'),
            ];
        } elseif ($image_env === "staging") {
            $icon_path = [
                'icon_path' => config('consts.info.storage_folders.icons.staging'),
                'icon_url' => config('consts.info.aws_s3.icons.url_staging'),
            ];
        } else {
            $icon_path = [
                'icon_path' => config('consts.info.storage_folders.icons.production'),
                'icon_url' => config('consts.info.aws_s3.icons.url_production'),
            ];
        }

        return $icon_path;
    }

    public function getBookImagePath()
    {
        $image_env = EnvironmentalConfirmation::veryfyEnvironment();

        if ($image_env === "local") {
            $book_path = [
                'book_path' => config('consts.info.storage_folders.books.local'),
                'book_url' => config('consts.info.aws_s3.books.url_local'),
            ];
        } elseif ($image_env === "staging") {
            $book_path = [
                'book_path' => config('consts.info.storage_folders.books.staging'),
                'book_url' => config('consts.info.aws_s3.books.url_staging'),
            ];
        } else {
            $book_path = [
                'book_path' => config('consts.info.storage_folders.books.production'),
                'book_url' => config('consts.info.aws_s3.books.url_production'),
            ];
        }
        return $book_path;
    }
}

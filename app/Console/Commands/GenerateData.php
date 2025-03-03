<?php

namespace App\Console\Commands;

use App\Helpers;
use App\Models\Category;
use App\Models\Post;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class GenerateData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:generate-data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $categoryImage = public_path('example/default.jpeg');
        $publicUploadCateImagePath = public_path('uploads/default.jpeg');
        if (!file_exists($publicUploadCateImagePath)) {
            copy($categoryImage, $publicUploadCateImagePath);
        }
        $languages = [
            'vi' => 'VN',
            'en' => 'EN',
            'lo' => 'LO'
        ];

        $defaultImagePath = 'uploads/default.jpeg';

        $translatableCate = ['name', 'desc', 'keywords'];
        $translatablePost = ['name', 'desc', 'keywords', 'content', 'summary'];
        foreach ([1,2,3,4] as $cateListIndex) {
            // create root categories
            $cate = Category::create([
                'parent_id' => null,
                'order' => $cateListIndex,
                'status' => Helpers::STATUS_ACTIVE,
                'image' => $defaultImagePath,
            ]);
            foreach ($translatableCate as $fieldName) {
                $translations = [];
                foreach ($languages as $langSign => $langName) {
                    $translations[$langSign] = "rootCategory$fieldName$langName$cateListIndex";
                }
                $cate->setTranslations($fieldName, $translations);
                $cate->save();
            }

            // each rootCate we create three subCate
            foreach ([1,2,3] as $subCateIndex) {
                // create root categories
                $subCate = Category::create([
                    'parent_id' => $cate->id,
                    'order' => $subCateIndex,
                    'status' => Helpers::STATUS_ACTIVE,
                    'image' => $defaultImagePath,
                ]);
                foreach ($translatableCate as $fieldName) {
                    $translations = [];
                    foreach ($languages as $langSign => $langName) {
                        $translations[$langSign] = "subCategory$fieldName$langName$subCateIndex";
                    }
                    $subCate->setTranslations($fieldName, $translations);
                    $subCate->save();
                }
                if ($subCateIndex == 1) {
                    foreach ([1,2,3,4,5,6,7,8,9,10] as $postIndex) {
                        // create 20 posts belong to
                        $post = Post::create([
                            'category_id' => $subCate->id,
                            'status' => Helpers::STATUS_ACTIVE,
                            'image' => $defaultImagePath,
                        ]);
                        foreach ($translatablePost as $fieldName) {
                            $translations = [];
                            foreach ($languages as $langSign => $langName) {
                                $translations[$langSign] = "post$fieldName$langName$postIndex";
                            }
                            $post->setTranslations($fieldName, $translations);
                            $post->save();
                        }
                    }
                } else {
                    // create one post
                    // create 20 posts belong to
                    $post = Post::create([
                        'category_id' => $subCate->id,
                        'status' => Helpers::STATUS_ACTIVE,
                        'image' => $defaultImagePath,
                    ]);
                    foreach ($translatablePost as $fieldName) {
                        $translations = [];
                        foreach ($languages as $langSign => $langName) {
                            $translations[$langSign] = "post$fieldName$langName";
                        }
                        $post->setTranslations($fieldName, $translations);
                        $post->save();
                    }
                }
            }
        }
    }
}

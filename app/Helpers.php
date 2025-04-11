<?php

namespace App;


use App\Models\Category;
use App\Models\Post;
use Backpack\Settings\app\Models\Setting;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Laravel\Facades\Image;
use function PHPUnit\Framework\directoryExists;

class Helpers
{

    public const SETTING_FIELDS = [
        'meta_index_title' => 'text',
        'meta_index_desc' => 'textarea',
        'meta_index_keywords' => 'text',

        'meta_contact_title' => 'text',
        'meta_contact_desc' => 'textarea',
        'meta_contact_keywords' => 'text',

        'website_name' => 'text',
        'analytics_code' => 'text',
        'webmaster_code' => 'text',

        'contact_phone' => 'text',
        'contact_email' => 'text',
        'contact_address' => 'textarea',
        'company_name' => 'text',
        'website_logo' => 'text',

        'facebook_link' => 'text',
        'twitter_link' => 'text',
        'instagram_link' => 'text',
        'pinterest_link' => 'text',
    ];
    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 2;
    const GENERAL_STATUSES = [
        self::STATUS_ACTIVE => 'Đang kích hoạt',
        self::STATUS_INACTIVE => 'Chưa kích hoạt',
    ];

    const LIMIT_POST_IN_LIST = 9;

    const INDEX_BLOCK_SERVICE_CATEGORY_ID = 2;

    public static function getCategories()
    {
        return Category::whereNull('parent_id')->where('status', self::STATUS_ACTIVE)->get();
    }

    public static function getImageUrlBySize($content, $w, $h)
    {
        if ($w > $h) {
            $path = $content->vertical_image;
        } else {
            $path = $content->horizontal_image;
        }

        if (!is_dir(public_path('temp'))) {
            mkdir(public_path('temp'), 0777, true);
        }
        $dirXH = $w.'x'.$h;
        $whDir = public_path('temp/'.$dirXH);
        if (!is_dir($whDir)) {
            mkdir($whDir, 0777, true);
        }
        $urlPath = 'temp/'.$dirXH.'/'.urlencode(str_replace('/', '-', $path));
        $existedPath = public_path($urlPath);
        if (file_exists($existedPath)) {
            return url($urlPath);
        }
        try {
            $imageManager = Image::read(Storage::disk('uploads')->get($path));
            $imageManager->resize($w, $h);
            $imageManager->save($existedPath);
            return url($urlPath);
        } catch (\Exception $exception) {
            self::log($exception->getMessage()." with path = ".$path." and urlPath=".$urlPath);
        }
        return url('/frontend/assets/img/demo1.jpg');
    }

    public  static function  getSettingByKey($key)
    {
        return Setting::get($key) ?? "";
    }

    public static function getIndexBlockServiceCate()
    {
        $blockCate = Category::find(self::INDEX_BLOCK_SERVICE_CATEGORY_ID);
        if (!$blockCate) {
            return null;
        }
        if ($blockCate->status !== self::STATUS_ACTIVE) {
            return null;
        }
        return $blockCate;
    }

    public static function getAllChildCategoryIds($categoryId)
    {
        $category = Category::find($categoryId);
        if (!$category) return []; // Nếu không tìm thấy category, trả về mảng rỗng

        $childIds = $category->children()->pluck('id')->toArray();

        // Duyệt qua từng danh mục con và gọi đệ quy để lấy danh mục con của nó
        foreach ($category->children as $child) {
            $childIds = array_merge($childIds, self::getAllChildCategoryIds($child->id));
        }

        return $childIds;
    }

    public  static function getFeatureIndexPosts()
    {
        return Post::where('status', self::STATUS_ACTIVE)
            ->where('is_feature', true)
            ->orderBy('id', 'desc')
            ->limit(4)
            ->get();
    }

    public static function getIndexNewsBlockCategoryWithPosts()
    {
        $cates = Category::whereNull('parent_id')
            ->where('status', self::STATUS_ACTIVE)
            ->where('is_news', true)
            ->get();

        if ($cates->count() == 0) {
            return [];
        }
        $res = [];
        foreach ($cates as $cate) {
            $tempRes = [
                'cate' => $cate,
                'posts' => [],
            ];
            // find posts related to cate
            // get all child cate of cate
            $childIds = self::getAllChildCategoryIds($cate->id);
            $posts = Post::where('status', self::STATUS_ACTIVE)
                ->whereIn('category_id', array_merge([$cate->id], $childIds))
                ->limit(5)
                ->get();
            if ($posts->count() > 0) {
                foreach ($posts as $post) {
                    $tempRes['posts'][] = $post;
                }
            }
            $res[] = $tempRes;
        }
        //self::log($res);
        return $res;
    }

    public static function log($msg): void
    {
        if (is_array($msg)) {
            $message = json_encode($msg, true);
        } else {
            $message = $msg;
        }
        @file_put_contents(storage_path('logs/debug.log'), $message . "\n", FILE_APPEND);
    }

}

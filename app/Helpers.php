<?php

namespace App;


use App\Models\Category;
use App\Models\Post;
use Backpack\Settings\app\Models\Setting;
use Intervention\Image\Laravel\Facades\Image;

class Helpers
{

    public const SETTINGS = [
        [
            'key'         => 'meta_index_title',
            'name'        => 'Meta Index Title',
            'description' => 'For SEO',
            'value'       => 'example.com',
            'field'       => '{"name":"value","label":"Value","type":"text"}', //text, textarea
            'active'      => 1,
        ],
        [
            'key'         => 'meta_index_desc',
            'name'        => 'Meta Index Description',
            'description' => 'For SEO',
            'value'       => 'example.com',
            'field'       => '{"name":"value","label":"Value","type":"textarea"}', //text, textarea
            'active'      => 1,
        ],
        [
            'key'         => 'meta_index_keywords',
            'name'        => 'Meta Index Keywords',
            'description' => 'For SEO',
            'value'       => 'example.com',
            'field'       => '{"name":"value","label":"Value","type":"text"}', //text, textarea
            'active'      => 1,
        ],
        [
            'key'         => 'meta_contact_title',
            'name'        => 'Meta Contact Title',
            'description' => 'For SEO',
            'value'       => 'example.com',
            'field'       => '{"name":"value","label":"Value","type":"text"}', //text, textarea
            'active'      => 1,
        ],
        [
            'key'         => 'meta_contact_desc',
            'name'        => 'Meta Contact Description',
            'description' => 'For SEO',
            'value'       => 'example.com',
            'field'       => '{"name":"value","label":"Value","type":"textarea"}', //text, textarea
            'active'      => 1,
        ],
        [
            'key'         => 'meta_contact_keywords',
            'name'        => 'Meta Contact Keywords',
            'description' => 'For SEO',
            'value'       => 'example.com',
            'field'       => '{"name":"value","label":"Value","type":"text"}', //text, textarea
            'active'      => 1,
        ],

        [
            'key'         => 'website_name',
            'name'        => 'Website Name',
            'description' => 'For SEO',
            'value'       => 'example.com',
            'field'       => '{"name":"value","label":"Value","type":"text"}', //text, textarea
            'active'      => 1,
        ],
        [
            'key'         => 'analytics',
            'name'        => 'Analytics Code',
            'description' => 'For SEO',
            'value'       => '',
            'field'       => '{"name":"value","label":"Value","type":"textarea"}', //text, textarea
            'active'      => 1,
        ],
        [
            'key'         => 'webmaster',
            'name'        => 'Webmaster Code',
            'description' => 'For SEO',
            'value'       => '',
            'field'       => '{"name":"value","label":"Value","type":"textarea"}', //text, textarea
            'active'      => 1,
        ],

        [
            'key'         => 'contact_phone',
            'name'        => 'Contact Phone',
            'description' => 'For SEO',
            'value'       => '(+880) 762 0813 <br/> (+785) 098 5648',
            'field'       => '{"name":"value","label":"Value","type":"text"}', //text, textarea
            'active'      => 1,
        ],
        [
            'key'         => 'contact_email',
            'name'        => 'Contact Email',
            'description' => 'For SEO',
            'value'       => 'banbientap@luxbrand.vn',
            'field'       => '{"name":"value","label":"Value","type":"text"}', //text, textarea
            'active'      => 1,
        ],
        [
            'key'         => 'address',
            'name'        => 'Address',
            'description' => 'For SEO',
            'value'       => 'Ta-134/A, Gulshan Badda <br/> Link Rd Dhaka',
            'field'       => '{"name":"value","label":"Value","type":"text"}', //text, textarea
            'active'      => 1,
        ],

        [
            'key'         => 'company_name',
            'name'        => 'Company Name',
            'description' => 'For SEO',
            'value'       => 'Công ty CP Truyền thông mùa vàng',
            'field'       => '{"name":"value","label":"Value","type":"text"}', //text, textarea
            'active'      => 1,
        ],

    ];
    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 2;
    const GENERAL_STATUSES = [
        self::STATUS_ACTIVE => 'Đang kích hoạt',
        self::STATUS_INACTIVE => 'Chưa kích hoạt',
    ];

    const INDEX_BLOCK_SERVICE_CATEGORY_ID = 2;

    public static function getCategories()
    {
        return Category::whereNull('parent_id')->where('status', self::STATUS_ACTIVE)->get();
    }

    public static function getImageUrlBySize($path, $w, $h)
    {
        $dirXH = $w.'x'.$h;
        if (!file_exists(public_path('temp/'.$dirXH))) {
            mkdir(public_path('temp/'.$dirXH), 0777, true);
        }
        $urlPath = 'temp/'.$dirXH.'/'.str_replace('/', '-', $path);
        $existedPath = public_path($urlPath);
        if (file_exists($existedPath)) {
            return url($urlPath);
        }
        try {
            $imageManager = Image::read(public_path($path));
            $imageManager->save(public_path($urlPath));
            return url($urlPath);
        } catch (\Exception $exception) {
            return url('frontend/assets/img/demo1.jpg');
        }

    }

    public  static function  getSettingByKey($key)
    {
        return Setting::get($key);
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
                ->whereIn('category_id', array_merge($cate->id, $childIds))
                ->limit(5)
                ->get();
            if ($posts->count() > 0) {
                foreach ($posts as $post) {
                    $tempRes['posts'][] = $post;
                }
            }
            $res[] = $tempRes;
        }
        return $res;
    }

}

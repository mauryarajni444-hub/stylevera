<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Api\Concerns\FormatsData;
use App\Models\{Product, Category, Banner, Setting};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CatalogController extends Controller
{
    use FormatsData;

    private array $productWith;

    public function __construct()
    {
        $this->productWith = [
            'variants' => fn($q) => $q->where('is_active', 1)->with('media'),
            'category',
        ];
    }

    public function home(Request $request)
    {
        $banners = Banner::where('position', 'hero')->where('is_active', 1)->orderBy('sort_order')->get();
        $promo = Banner::where('position', 'promo')->where('is_active', 1)->orderBy('sort_order')->get();
        $featuredCats = Category::where('is_featured', 1)->where('is_active', 1)->orderBy('sort_order')->take(6)->get();
        $newArrivals = Product::with($this->productWith)->where('is_new_arrival', 1)->where('is_active', 1)->orderBy('sort_order')->take(10)->get();
        $bestSellers = Product::with($this->productWith)->where('is_best_seller', 1)->where('is_active', 1)->orderBy('sort_order')->take(10)->get();
        $featured = Product::with($this->productWith)->where('is_featured', 1)->where('is_active', 1)->orderBy('sort_order')->take(10)->get();

        return response()->json([
            'store' => [
                'name' => Setting::get('general.store_name_en', 'Stylevera'),
                'tagline' => Setting::get('general.tagline_en', 'Dress Your Story'),
                'currency' => 'AED',
                'shipping_fee' => (float) Setting::get('general.shipping_fee', 30),
                'free_shipping_above' => (float) Setting::get('general.free_shipping_above', 500),
            ],
            'banners' => $banners->map(fn($b) => $this->fmtBanner($b))->values(),
            'promo_banners' => $promo->map(fn($b) => $this->fmtBanner($b))->values(),
            'featured_categories' => $featuredCats->map(fn($c) => $this->fmtCategory($c))->values(),
            'featured_products' => $featured->map(fn($p) => $this->fmtProduct($p))->values(),
            'new_arrivals' => $newArrivals->map(fn($p) => $this->fmtProduct($p))->values(),
            'best_sellers' => $bestSellers->map(fn($p) => $this->fmtProduct($p))->values(),
        ]);
    }

    public function categories()
    {
        $categories = Category::where('is_active', 1)->withCount('products')->orderBy('sort_order')->get();
        return response()->json(['categories' => $categories->map(fn($c) => $this->fmtCategory($c))->values()]);
    }

    public function products(Request $request)
    {
        $q = Product::with($this->productWith)->where('is_active', 1);

        if ($request->category) {
            $q->whereHas('category', fn($x) => $x->where('slug', $request->category));
        }
        if ($request->gender) {
            $q->where('gender', $request->gender);
        }
        if ($request->search) {
            $term = $request->search;
            $q->where(fn($x) => $x->where('name_en', 'like', "%{$term}%")->orWhere('name_ar', 'like', "%{$term}%"));
        }
        if ($request->min_price) {
            $q->where('base_price', '>=', $request->min_price);
        }
        if ($request->max_price) {
            $q->where('base_price', '<=', $request->max_price);
        }
        if ($request->boolean('is_featured')) {
            $q->where('is_featured', 1);
        }
        if ($request->boolean('is_new_arrival')) {
            $q->where('is_new_arrival', 1);
        }
        if ($request->boolean('is_best_seller')) {
            $q->where('is_best_seller', 1);
        }

        match ($request->sort ?? '') {
            'price_asc' => $q->orderBy('base_price'),
            'price_desc' => $q->orderByDesc('base_price'),
            'newest' => $q->orderByDesc('created_at'),
            'rating' => $q->orderByDesc('rating'),
            default => $q->orderBy('sort_order'),
        };

        $perPage = min((int) $request->input('per_page', 12), 50);
        $paginated = $q->paginate($perPage);

        return response()->json([
            'products' => collect($paginated->items())->map(fn($p) => $this->fmtProduct($p))->values(),
            'pagination' => [
                'current_page' => $paginated->currentPage(),
                'last_page' => $paginated->lastPage(),
                'per_page' => $paginated->perPage(),
                'total' => $paginated->total(),
            ],
        ]);
    }

    public function show(string $slug)
    {
        $product = Product::with([
            'category',
            'variants' => fn($q) => $q->where('is_active', 1)->with('media'),
            'reviews' => fn($q) => $q->where('is_approved', 1)->orderByDesc('created_at'),
        ])->where('slug', $slug)->where('is_active', 1)->firstOrFail();

        $product->increment('views');

        $related = Product::with($this->productWith)
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->where('is_active', 1)
            ->take(8)->get();

        return response()->json([
            'product' => $this->fmtProduct($product, true),
            'related' => $related->map(fn($p) => $this->fmtProduct($p))->values(),
        ]);
    }

    public function addReview(Request $request, int $productId)
    {
        $v = Validator::make($request->all(), [
            'rating' => 'required|integer|min:1|max:5',
            'content' => 'required|string|max:2000',
        ]);
        if ($v->fails()) {
            return response()->json(['message' => $v->errors()->first()], 422);
        }

        $product = Product::findOrFail($productId);
        $user = $request->attributes->get('api_user');

        $review = $product->reviews()->create([
            'user_id' => $user->id,
            'name' => $user->name,
            'rating' => $request->rating,
            'content' => $request->content,
            'is_approved' => 0,
        ]);

        return response()->json([
            'message' => 'Thank you! Your review will appear after approval.',
            'review' => ['id' => $review->id],
        ], 201);
    }

    public function settings()
    {
        return response()->json(['settings' => Setting::all()->pluck('value', 'key')]);
    }
}

<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{VariantMedia, ProductVariant, Product, Category, Banner};
use Aws\S3\S3Client;
use Aws\Exception\AwsException;

class AdminMediaController extends Controller
{
    private function s3(): S3Client {
        return new S3Client([
            'version'     => 'latest',
            'region'      => env('AWS_DEFAULT_REGION', 'us-east-1'),
            'credentials' => [
                'key'    => env('AWS_ACCESS_KEY_ID'),
                'secret' => env('AWS_SECRET_ACCESS_KEY'),
            ],
        ]);
    }

    private function uploadToS3($file, string $folder): array {
        $bucket = env('AWS_BUCKET', 'rajni-app-bucket-2026');
        $region = env('AWS_DEFAULT_REGION', 'us-east-1');
        $ext    = strtolower($file->getClientOriginalExtension());
        $key    = "stylevera/{$folder}/" . time() . '_' . uniqid() . '.' . $ext;
        $mime   = $file->getMimeType();
        $isVid  = str_starts_with($mime, 'video/');

        try {
            $this->s3()->putObject([
                'Bucket'      => $bucket,
                'Key'         => $key,
                'Body'        => fopen($file->getRealPath(), 'rb'),
                'ContentType' => $mime,
            ]);
            return [
                'success' => true,
                'url'     => "https://{$bucket}.s3.{$region}.amazonaws.com/{$key}",
                'type'    => $isVid ? 'video' : 'image',
            ];
        } catch (AwsException $e) {
            return ['success' => false, 'message' => 'S3 Error: ' . $e->getAwsErrorMessage()];
        } catch (\Exception $e) {
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }

    /* ── Variant Media (VMM) ─────────────────────────────────── */
    public function uploadVariantMedia(Request $request, ProductVariant $variant) {
        $request->validate(['file' => 'required|file|max:204800']); // 200MB
        $r = $this->uploadToS3($request->file('file'), "variants/{$variant->id}");
        if (!$r['success']) return response()->json($r, 422);
        $hasPrimary = VariantMedia::where('variant_id', $variant->id)->where('is_primary', 1)->exists();
        $m = VariantMedia::create([
            'variant_id' => $variant->id,
            'type'       => $r['type'],
            'url'        => $r['url'],
            'is_primary' => $hasPrimary ? 0 : 1,
            'sort_order' => VariantMedia::where('variant_id', $variant->id)->count(),
            'file_size'  => $request->file('file')->getSize(),
        ]);
        return response()->json(['success' => true, 'media' => $m]);
    }

    public function getVariantMediaList(ProductVariant $variant) {
        $media = VariantMedia::where('variant_id', $variant->id)->orderByDesc('is_primary')->orderBy('sort_order')->get();
        return response()->json(['success' => true, 'media' => $media]);
    }

    public function setVariantPrimary($mediaId) {
        $m = VariantMedia::findOrFail($mediaId);
        VariantMedia::where('variant_id', $m->variant_id)->update(['is_primary' => 0]);
        $m->update(['is_primary' => 1]);
        return response()->json(['success' => true]);
    }

    public function destroyVariantMedia($mediaId) {
        $m = VariantMedia::findOrFail($mediaId);
        $wasPrimary = $m->is_primary;
        $vid = $m->variant_id;
        $m->delete();
        if ($wasPrimary) {
            $next = VariantMedia::where('variant_id', $vid)->first();
            if ($next) $next->update(['is_primary' => 1]);
        }
        return response()->json(['success' => true]);
    }

    /* ── Product Cover ───────────────────────────────────────── */
    public function uploadProductCover(Request $request, Product $product) {
        $request->validate(['file' => 'required|image|max:10240']);
        $r = $this->uploadToS3($request->file('file'), "products/{$product->id}/cover");
        if (!$r['success']) return response()->json($r, 422);
        $product->update(['cover_image' => $r['url']]);
        return response()->json(['success' => true, 'url' => $r['url']]);
    }

    /* ── Category Image ──────────────────────────────────────── */
    public function uploadCategoryImage(Request $request, Category $cat) {
        $request->validate(['file' => 'required|image|max:10240']);
        $r = $this->uploadToS3($request->file('file'), "categories/{$cat->id}");
        if (!$r['success']) return response()->json($r, 422);
        $cat->update(['image' => $r['url']]);
        return response()->json(['success' => true, 'url' => $r['url']]);
    }

    /* ── Banner Image ────────────────────────────────────────── */
    public function uploadBannerImage(Request $request, Banner $b) {
        $request->validate(['file' => 'required|image|max:10240']);
        $r = $this->uploadToS3($request->file('file'), "banners/{$b->id}");
        if (!$r['success']) return response()->json($r, 422);
        $b->update(['image' => $r['url']]);
        return response()->json(['success' => true, 'url' => $r['url']]);
    }
}

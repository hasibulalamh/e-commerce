<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Models\Wishlist;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    public function index()
    {
        $wishlistItems = Wishlist::where('customer_id', auth('customerg')->id())
            ->with('product')
            ->latest()
            ->paginate(10);
        return view('frontend.pages.wishlist', compact('wishlistItems'));
    }

    public function toggle($productId)
    {
        if (!auth('customerg')->check()) {
            return response()->json(['success' => false, 'message' => 'Please login first.']);
        }

        $customer = auth('customerg')->user();
        $wishlist = Wishlist::where('customer_id', $customer->id)
            ->where('product_id', $productId)
            ->first();

        if ($wishlist) {
            $wishlist->delete();
            return response()->json(['success' => true, 'action' => 'removed', 'message' => 'Removed from wishlist.']);
        } else {
            Wishlist::create([
                'customer_id' => $customer->id,
                'product_id' => $productId
            ]);
            return response()->json(['success' => true, 'action' => 'added', 'message' => 'Added to wishlist.']);
        }
    }

    public function remove($id)
    {
        $wishlist = Wishlist::where('id', $id)
            ->where('customer_id', auth('customerg')->id())
            ->firstOrFail();
        $wishlist->delete();
        toastr()->success('Item removed from wishlist.');
        return redirect()->back();
    }
}

<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function addtocart($product_id)
    {
        $product = Product::find($product_id);
        if (!$product) {
            if (request()->ajax()) {
                return response()->json(['success' => false, 'message' => 'Product not found']);
            }
            return redirect()->back();
        }

        if ($product->stock < 1) {
            if (request()->ajax()) {
                return response()->json(['success' => false, 'message' => 'Out of stock!']);
            }
            toastr()->error('Out of stock!');
            return redirect()->back();
        }

        $mycart = Session::get('cart', []);
        $currentQty = isset($mycart[$product_id]) ? $mycart[$product_id]['quantity'] : 0;

        if ($currentQty + 1 > $product->stock) {
            if (request()->ajax()) {
                return response()->json(['success' => false, 'message' => 'Not enough stock!']);
            }
            toastr()->error('Not enough stock!');
            return redirect()->back();
        }

        if (isset($mycart[$product_id])) {
            $mycart[$product_id]['quantity']++;
            $mycart[$product_id]['subtotal'] = $mycart[$product_id]['price'] * $mycart[$product_id]['quantity'];
        } else {
            $mycart[$product_id] = [
                'id'             => $product->id,
                'name'           => $product->name,
                'price'          => $product->final_price,
                'original_price' => $product->price,
                'discount'       => $product->discount,
                'quantity'       => 1,
                'image'          => $product->image,
                'subtotal'       => $product->final_price,
            ];
        }

        Session::put('cart', $mycart);
        $cartCount = count($mycart);

        if (request()->ajax()) {
            return response()->json([
                'success'    => true,
                'message'    => $product->name . ' added to cart!',
                'cart_count' => $cartCount,
            ]);
        }

        toastr()->success('Item added to cart');
        return redirect()->back();
    }

    public function view(){
        $mycart = Session::get('cart') ?? [];

        return view('frontend.shopping.cart',compact('mycart'));

    }



    public function checkout(){
        $mycart = Session::get('cart') ?? [];
        $addresses = auth('customerg')->user()->addresses()->get();
        return view('frontend.shopping.checkout', compact('mycart', 'addresses'));
    }

    public function storeaddorder(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'number' => 'required|string|max:20',
            'address' => 'required|string|max:500',
            'city' => 'required|string|max:100',
            'zip_code' => 'nullable|string|max:20',
            'pay' => 'required|in:CASH,SSL',
        ]);

        $mycart = Session::get('cart');
        if (empty($mycart)) {
            toastr()->title('Order Error')->error('Your cart is empty!');
            return redirect()->back();
        }

        DB::beginTransaction();
        try {
            // Server-side calculation to prevent price manipulation
            $subtotal = 0;
            foreach ($mycart as $item) {
                $subtotal += $item['price'] * $item['quantity'];
            }
            $shipping_cost = 100;
            $total = $subtotal + $shipping_cost;

            $myorder = Order::create([
                'customer_id'      => auth('customerg')->user()->id,
                'name'             => $request->name,
                'email'            => $request->email,
                'phone'            => $request->number,
                'address'          => $request->address,
                'city'             => $request->city,
                'receiver_name'    => $request->name,
                'receiver_email'   => $request->email,
                'receiver_mobile'  => $request->number,
                'receiver_address' => $request->address,
                'receiver_city'    => $request->city,
                'subtotal'         => $subtotal,
                'shipping_cost'    => $shipping_cost,
                'tax'              => 0,
                'total'            => $total,
                'payment_method'   => $request->pay,
                'status'           => 'pending',
            ]);

            foreach ($mycart as $cartdata) {
                $product = Product::find($cartdata['id']);
                
                // Final stock check
                if (!$product || $product->stock < $cartdata['quantity']) {
                    throw new \Exception("Product '{$cartdata['name']}' is out of stock.");
                }

                // Decrement stock
                $product->decrement('stock', $cartdata['quantity']);

                OrderDetail::create([
                    'order_id' => $myorder->id,
                    'product_id' => $cartdata['id'],
                    'quantity' => $cartdata['quantity'],
                    'price' => $cartdata['price'],
                ]);
            }

            DB::commit();
            toastr()->title('Place Order')->success('Order placed successfully!');
            Session::forget('cart');
            return redirect()->route('Home');

        } catch (\Exception $e) {
            DB::rollBack();
            toastr()->title('Order Error')->error($e->getMessage());
            return redirect()->back();
        }
    }

    public function removecart($id)
    {
        $cart = Session::get('cart', []);
        if (isset($cart[$id])) {
            unset($cart[$id]);
            Session::put('cart', $cart);
            toastr()->success('Item removed from cart');
        }
        return redirect()->route('cart.view');
    }

    public function updatecart(Request $request)
    {
        $request->validate([
            'quantities' => 'required|array',
            'quantities.*' => 'integer|min:1|max:100',
        ]);

        $cart = Session::get('cart', []);
        foreach ($request->quantities as $productId => $quantity) {
            if (isset($cart[$productId])) {
                // Stock validation
                $product = Product::find($productId);
                if ($product && $quantity > $product->stock) {
                    toastr()->error("Not enough stock for '{$product->name}'. Available: {$product->stock}");
                    continue;
                }

                $cart[$productId]['quantity'] = $quantity;
                $cart[$productId]['subtotal'] = $cart[$productId]['price'] * $quantity;
            }
        }
        Session::put('cart', $cart);
        toastr()->success('Cart updated successfully');
        return redirect()->route('cart.view');
    }

    public function myorders()
    {
        $orders = Order::where('customer_id', auth('customerg')->user()->id)
            ->with('orderDetails')
            ->latest()
            ->paginate(10);
        return view('frontend.pages.myorders', compact('orders'));
    }

    public function orderdetail($id)
    {
        $order = Order::where('id', $id)
            ->where('customer_id', auth('customerg')->user()->id)
            ->with(['orderDetails.product', 'statusHistories'])
            ->first();

        if (!$order) {
            abort(403, 'Unauthorized access.');
        }

        return view('frontend.pages.orderdetail', compact('order'));
    }
}

<?php

namespace App\Http\Controllers;

use App\Facades\Cart;
use App\Models\Borrow;
use App\Models\BorrowBook;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class BorrowController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('is_admin')->except([
            'create',
            'store',
            'mine',
            'books',
            'pay',
            'payConfirm'
        ]);
    }

    public function index()
    {
        $from = request()->from_date;
        $to = request()->to_date;
        $fromDate = null;
        $toDate = null;
        if ($from) {
            $fromDate = date('Y-m-d', strtotime($from));
        }

        if ($to) {
            $toDate = date('Y-m-d', strtotime($to));
        }

        if ($fromDate && $toDate) {
            $borrows = Borrow::whereBetween('started_at', array($fromDate, $toDate))->get();
            // ->whereBetween('deadline', array($fromDate, $toDate))->get();
            return view('borrows.index', ['borrows' => $borrows]);
        }

        // At exact date
        else if ($fromDate) {
            $borrows = Borrow::whereDate('started_at', '=', $fromDate)->get();
            // ->orWhereDate('deadline', '=', $fromDate)->get();

            return view('borrows.index', ['borrows' => $borrows]);
        }

        $borrows = Borrow::with(['user'])->get();
        return view('borrows.index', ['borrows' => $borrows]);
    }

    public function create()
    {
        return view('borrows.create');
    }

    public function Store(Request $request)
    {
        $fields = $request->validate([
            'address' => ['required', 'max:255'],
            'payment' => ['required'],
        ]);

        // Set borrow status
        if ($fields['payment'] == 'CASH') {
            $fields['status'] = 'WAITING_FOR_PAYMENT';
        } else if ($fields['payment'] == 'E_PAYMENT') {
            $fields['status'] = 'DELIVERING';
        }

        $user = Auth::user();

        // Password required for payment check
        if ($fields['payment'] == 'E_PAYMENT') {
            $request->validate(['password' => 'required']);

            $passwordValid = Auth::validate([
                'email' => $user,
                'password' => $request->password
            ]);

            if (!$passwordValid) {
                return back()->with('error', 'Password Is Invalid!');
            }
        }

        $cart = Cart::content();

        // Cart must have at least one item
        if (count($cart) == 0) {
            return back()->with('error', 'Cart Is Empty!');
        }

        $totalPrice = 0.0;
        // Calculate total cart price
        foreach ($cart as $id => $item) {
            $totalPrice += $item->get('price');
        }

        $userToUpdate = User::find($user->id);
        $wallet = $userToUpdate->wallet - $totalPrice;

        // Check user wallet
        if ($wallet < 0) {
            return back()->with('error', "You Don't Have Enough Mony!");
        }

        $borrow = Borrow::create([
            'user_id' => $user->id,
            'address' => $fields['address'],
            'status' => $fields['status'],
            'started_at' => Carbon::now(),
            'deadline' => Carbon::now()->addDays(15),
        ]);

        foreach ($cart as $id => $item) {
            BorrowBook::create([
                'book_id' => $item->get('id'),
                'borrow_id' => $borrow->id,
                'price' => $item->get('price'),
                'sale_price' => $item->get('price'),
            ]);
        }

        $userToUpdate->update([
            'wallet' => $wallet
        ]);

        Cart::clear();
        return redirect('/')->with('Order Created Successfully!');
    }

    public function edit($id)
    {
        $borrow = Borrow::find($id);

        if (!$borrow) {
            throw new NotFoundHttpException();
        }

        $items = BorrowBook::with('book')->where('borrow_id', '=', $id)->get();
        return view('borrows.edit', ['borrow' => $borrow, 'items' => $items]);
    }

    public function update(Request $request, $id)
    {
        $borrow = Borrow::find($id);

        if (!$borrow) {
            throw new NotFoundHttpException();
        }

        $fields = $request->validate([
            'status' => ['required']
        ]);

        if ($fields['status'] == 'DONE') {
            $fields['returned_at'] = Carbon::now();
        }

        // Update on pending or waiting for payment status only!
        if ($borrow->status == "WAITING_FOR_PAYMENT" || $borrow->status == "PENDING") {
            $borrow->update($fields);
        }

        return redirect('/borrows')->with('message', 'Borrow Updated Successfully!');
    }

    public function pay($id)
    {
        $borrow = Borrow::find($id);

        if (!$borrow) {
            throw new NotFoundHttpException();
        }

        $items = BorrowBook::with('book')->where('borrow_id', '=', $id)->get();
        return view('borrows.pay', ['borrow' => $borrow, 'items' => $items]);
    }

    public function payConfirm(Request $request, $id)
    {
        $borrow = Borrow::find($id);
        if (!$borrow) {
            throw new NotFoundHttpException();
        }

        $fields = $request->validate([
            'password' => ['required']
        ]);

        if ($borrow->status != 'WAITING_FOR_PAYMENT') {
            return back()->with('error', 'Can\'t Pay For This');
        }

        $fields['status'] = 'DELIVERING';

        $user = Auth::user();
        // Password required for payment check
        $passwordValid = Auth::validate([
            'email' => $user,
            'password' => $request->password
        ]);

        if (!$passwordValid) {
            return back()->with('error', 'Password Is Invalid!');
        }

        $books = BorrowBook::where('borrow_id', '=', $id)->get();
        $totalPrice = 0.0;
        // Calculate total cart price
        foreach ($books as $id => $item) {
            $totalPrice += $item->sale_price;
        }

        $userToUpdate = User::find($user->id);
        $wallet = $userToUpdate->wallet - $totalPrice;

        // Check user wallet
        if ($wallet < 0) {
            return back()->with('error', "You Don't Have Enough Mony!");
        }

        $borrow->update($fields);

        $userToUpdate->update([
            'wallet' => $wallet
        ]);

        return redirect('/borrows/mine')->with('message', 'Borrow Updated Successfully!');
    }

    // Get the user borrows
    public function mine()
    {
        $borrows = Borrow::where('user_id', '=', Auth::user()->id)->get();
        return view('borrows.mine', ['borrows' => $borrows]);
    }

    public function books($id)
    {
        $items = BorrowBook::with('book')->where('borrow_id', '=', $id)->get();
        return view('borrows.books', ['items' => $items]);
    }
}

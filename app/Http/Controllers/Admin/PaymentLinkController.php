<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PaymentLink;
use Illuminate\Http\Resources\Json\PaginatedResourceResponse;

class PaymentLinkController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:admin.payments.index')->only('index');
        $this->middleware('can:admin.payments.create')->only('create');
        $this->middleware('can:admin.payments.show')->only('show');
        $this->middleware('can:admin.payments.edit')->only('edit');
        $this->middleware('can:admin.payments.update')->only('update');
        $this->middleware('can:admin.payments.store')->only('store');
        $this->middleware('can:admin.payments.destroy')->only('destroy');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $paymentLinks = PaymentLink::paginate(5);

        return view('admin.payments.index', ['paymentLinks' => $paymentLinks]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.payments.form');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}

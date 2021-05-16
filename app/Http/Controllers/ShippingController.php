<?php


namespace App\Http\Controllers;


use App\Models\ShippingApiModel;
use Illuminate\Http\Request;


class ShippingController extends Controller
{
    private $shippingApiModel = null;

    public function __construct()
    {
        $this->shippingApiModel = new ShippingApiModel();
    }

    public function mainPage()
    {
        return view('home', []);
    }

    public function login(Request $request)
    {
        $validation = $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:3|max:256'
        ]);
        return $this->shippingApiModel->login(
            $request->input('email'),
            $request->input('password')
        );
    }

    public function getShipmentList(Request $request)
    {
        $validation = $request->validate([
            'token' => 'required|min:10'
        ]);
        return $this->shippingApiModel->getListOfShipments(
            $request->input('token')
        );
    }

    public function createShipment(Request $request)
    {
        $validation = $request->validate([
            'token' => 'required|min:10',
            'name' => 'required'
        ]);
        return $this->shippingApiModel->createShipment(
            $request->input('token'),
            $request->input('name')
        );
    }

    public function updateShipment(Request $request) {
        $validation = $request->validate([
            'token' => 'required|min:10',
            'shipment_name' => 'required',
            'shipment_id' => 'required',
        ]);
        $this->shippingApiModel->updateShipment(
            $request->input('token'),
            $request->input('shipment_id'),
            $request->input('shipment_name')
        );
    }

    public function deleteShipment(Request $request) {
        $validation = $request->validate([
            'token' => 'required|min:10',
            'shipment_id' => 'required'
        ]);
        $this->shippingApiModel->deleteShipment(
            $request->input('token'),
            $request->input('shipment_id')
        );
    }

    public function createItem(Request $request) {
        $validation = $request->validate([
            'token' => 'required|min:10',
            'shipment_id' => 'required',
            'code' => 'required',
            'name' => 'required'
        ]);
        return $this->shippingApiModel->createItem(
            $request->input('token'),
            $request->input('name'),
            $request->input('code'),
            $request->input('shipment_id')
        );
    }

    public function updateItem(Request $request) {
        $validation = $request->validate([
            'token' => 'required|min:10',
            'item_id' => 'required',
            'shipment_id' => 'required',
            'item_name' => 'required',
            'item_code' => 'required'
        ]);
        $this->shippingApiModel->updateItem(
            $request->input('token'),
            $request->input('item_id'),
            $request->input('shipment_id'),
            $request->input('item_name'),
            $request->input('item_code'),
        );
    }

    public function deleteItem(Request $request) {
        $validation = $request->validate([
            'token' => 'required|min:10',
            'item_id' => 'required'
        ]);
        $this->shippingApiModel->deleteItem(
            $request->input('token'),
            $request->input('item_id')
        );
    }


}

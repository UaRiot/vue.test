<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShippingApiModel extends Model
{
    use HasFactory;

    private $base_url = 'https://api.shipments.test-y-sbm.com/';

    public function login($email, $password)
    {
        $curl = curl_init($this->base_url . 'login');
        $data = json_encode(['email' => $email, 'password' => $password]);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($curl);
        curl_close($curl);
        return $result;
    }

    public function getListOfShipments($token)
    {
        $curl = curl_init($this->base_url . 'shipment?token=' . $token);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($curl);
        curl_close($curl);
        return $result;
    }

    public function createShipment($token, $name)
    {
        $id = rand(10000, 20000);
        $curl = curl_init($this->base_url . 'shipment?token=' . $token);
        $data = json_encode(['id' => $id, 'name' => $name]);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($curl);
        $status = json_decode($result);
        curl_close($curl);
        if (isset($status->status_code) && $status->status_code == 500){
            $this->createShipment($token, $name);
        }else{
            return ['status' => 1];
        }
    }

    public function updateShipment($token, $id, $name)
    {
        $curl = curl_init($this->base_url . 'shipment/'. $id. '?token=' . $token);
        $data = json_encode(['id' => $id, 'name' => $name]);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($curl);
        curl_close($curl);
        return $result;
    }

    public function deleteShipment($token, $id)
    {
        $curl = curl_init($this->base_url . 'shipment/'. $id. '?token=' . $token);
        $data = json_encode(['id' => $id]);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "DELETE");
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($curl);
        curl_close($curl);
        return $result;
    }

    public function createItem($token, $name, $code, $shipment_id)
    {
        $id = rand(10000, 20000);
        $curl = curl_init($this->base_url . 'item?token=' . $token);
        $data = json_encode(['id' => $id, 'name' => $name, 'code' => $code, 'shipment_id'=> $shipment_id]);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($curl);
        $status = json_decode($result);
        curl_close($curl);
        if (isset($status->status_code) && $status->status_code == 500){
            $this->createItem($token, $name);
        }else{
            return ['status' => 1];
        }
    }

    public function deleteItem($token, $id)
    {
        $curl = curl_init($this->base_url . 'item/'.$id.'?token=' . $token);
        $data = json_encode(['id' => $id]);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "DELETE");
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($curl);
        curl_close($curl);
        return $result;
    }


    public function updateItem($token, $id, $shipment_id, $name, $code)
    {
        $curl = curl_init($this->base_url . 'item/'. $id. '?token=' . $token);
        $data = json_encode(
            [
                'id' => $id,
                'name' => $name,
                'code'=> $code,
                'shipment_id' => $shipment_id
            ]
        );
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($curl);
        curl_close($curl);
        return $result;
    }
}

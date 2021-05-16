@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <h3>admin36@gmail.com</h3>
                <h3>123</h3>
                <div class="card">
                    <div class="card-header">Shipping system</div>

                    <div class="card-body">
                        <div v-if="!authorized">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Email address</label>
                                <input type="email" class="form-control" id="exampleInputEmail1"
                                       aria-describedby="emailHelp" v-model="loginData.email">
                                <small id="emailHelp" class="form-text text-muted">We'll never share your email with
                                    anyone else.</small>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Password</label>
                                <input type="password" class="form-control" id="exampleInputPassword1"
                                       v-model="loginData.password">
                            </div>
                            <button @click="tryLogin" class="btn btn-primary">Submit</button>
                        </div>
                        <div v-if="authorized">
                            <div class="text-center">
                                <button @click="startShipmentCreation" class="btn btn-success">Create</button>
                                <button @click="getShipmentList" class="btn btn-primary">REFRESH</button>
                            </div>
                            <div class="mt-5">
                                <div v-for="(shipment) in shipments" >
                                    <shipment-card
                                        :shipment="shipment"
                                        v-on:start-item-creation="startItemCreation"
                                        v-on:start-shipment-delete="deleteShipment"
                                        v-on:start-item-delete="deleteItem"
                                        v-on:start-shipment-update="startShipmentUpdate"
                                        v-on:start-item-update="startItemUpdate"
                                    ></shipment-card>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--   CREATE SHIPMENT MODAL     -->
        <div class="modal-background" v-if="createShipmentData.openModal" @click="createShipmentData.openModal = false"></div>
        <div class="shipment-create-modal" v-if="createShipmentData.openModal">
            <div class="form-group text-center">
                <div v-if="createShipmentData.hasError">
                    <error-block :error_text="createShipmentData.errorText"></error-block>
                </div>
                <label for="createShipmentName">Shipment name</label>
                <input type="text" class="form-control" id="createShipmentName"
                       v-model="createShipmentData.shipmentName">
                <button @click="createShipment" class="btn btn-success mt-3">Create</button>
            </div>
        </div>
        <!--   UPDATE SHIPMENT MODAL     -->
        <div class="modal-background" v-if="updateShipmentData.openModal" @click="updateShipmentData.openModal = false"></div>
        <div class="shipment-create-modal" v-if="updateShipmentData.openModal">
            <div class="form-group text-center">
                <div v-if="updateShipmentData.hasError">
                    <error-block :error_text="updateShipmentData.errorText"></error-block>
                </div>
                <label for="createShipmentName">Shipment name</label>
                <input type="text" class="form-control" id="createShipmentName"
                       v-model="updateShipmentData.shipmentName">
                <button @click="updateShipment" class="btn btn-success mt-3">Update</button>
            </div>
        </div>

        <!--   UPDATE ITEM MODAL     -->
        <div class="modal-background" v-if="createItemData.openModal" @click="createItemData.openModal = false"></div>
        <div class="shipment-create-modal" v-if="createItemData.openModal">
            <div class="form-group text-center">
                <div v-if="createItemData.hasError">
                    <error-block :error_text="createItemData.errorText"></error-block>
                </div>Create
                <label for="createItemName">Item name</label>
                <input type="text" class="form-control" id="createItemName"
                       v-model="createItemData.itemName">
                <label for="createItemCode">Item code</label>
                <input type="text" class="form-control" id="createItemCode"
                       aria-describedby="emailHelp" v-model="createItemData.code">
                <button @click="createItem" class="btn btn-success mt-3">Update</button>
            </div>
        </div>
        <!--   CREATE ITEM MODAL     -->
        <div class="modal-background" v-if="updateItemData.openModal" @click="updateItemData.openModal = false"></div>
        <div class="shipment-create-modal" v-if="updateItemData.openModal">
            <div class="form-group text-center">
                <div v-if="updateItemData.hasError">
                    <error-block :error_text="updateItemData.errorText"></error-block>
                </div>Create
                <label for="createItemName">Item name</label>
                <input type="text" class="form-control" id="createItemName"
                       v-model="updateItemData.itemName">
                <label for="createItemCode">Item code</label>
                <input type="text" class="form-control" id="createItemCode"
                       aria-describedby="emailHelp" v-model="updateItemData.code">
                <button @click="updateItem" class="btn btn-success mt-3">Update</button>
            </div>
        </div>
    </div>
@endsection

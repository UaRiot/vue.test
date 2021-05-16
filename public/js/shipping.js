Vue.component(
    'shipment-card',
    {
        props: {
            shipment: {
                type: Object
            }
        },
        methods: {
            itemCreation: function(){
                this.$emit('start-item-creation', this.shipment.id);
            },
            shipmentUpdate: function () {
                this.$emit('start-shipment-update', this.shipment.id);
            },
            shipmentDelete: function () {
                this.$emit('start-shipment-delete', this.shipment);
            },
            startItemDelete: function (item_id) {
                this.$emit('start-item-delete', item_id);
            },
            startItemUpdate: function (item){
                this.$emit('start-item-update', item_id);
            }
        },
        template: `<div class="card col-12" >
                                    <div class="card-body">
                                        <h5 class="card-title">Name: {{shipment.name}}</h5>
                                        <h6 class="card-subtitle mb-2 text-muted">ID: {{shipment.id}}</h6>
                                        <p class="card-text">Send: {{shipment.is_send}}</p>
                                        <div class="text-center">
                                            <button class="btn btn-warning" @click="itemCreation">Create item</button>
                                            <button class="btn btn-warning" @click="shipmentUpdate">Update</button>
                                            <button class="btn btn-danger"  @click="shipmentDelete">Delete</button>
                                        </div>
                                        <h5>Items</h5>
                                        <div class="container col-12 row mt-3">
                                            <shipment-item
                                                v-for="(item) in shipment.items"
                                                :item="item"
                                                v-on:start-item-delete="startItemDelete"
                                                v-on:start-item-update="startItemUpdate"
                                            ></shipment-item>
                                        </div>
                                    </div>
                                </div>`
    }
);
Vue.component(
    'shipment-item',
    {
        props: {
            item: {
                type: Object
            }
        },
        methods: {
            itemUpdate: function () {
                this.$emit('start-item-delete', this.item);
            },
            itemDelete: function () {
                this.$emit('start-item-delete', this.item.id);
            }
        },
        template: `<div class="card col-4" >
                                    <div class="card-body">
                                        <h5 class="card-title">Name: {{item.name}}</h5>
                                        <h6 class="card-subtitle mb-2 text-muted">ID: {{item.id}}</h6>
                                        <p class="card-text">Send: {{item.code}}</p>
                                        <div class="text-center">
                                            <button class="btn btn-warning" @click="itemUpdate">Update</button>
                                            <button class="btn btn-danger" @click="itemDelete">Delete</button>
                                        </div>
                                    </div>
                                </div>`
    }
);
Vue.component(
    'error-block',
    {
        props: ['error_text'],
        template: `<p class="error_text">{{error_text}}</p>`
    }
);
var app = new Vue({
        el: '#app',
        data: {
            token: "",
            authorized: false,
            shipments: {},
            loginData:
                {
                    email: "",
                    password: ""
                },
            createShipmentData: {
                openModal: false,
                shipmentName: "",
                hasError: false,
                errorText: "",
            },
            updateShipmentData: {
                openModal: false,
                shipmentName: "",
                hasError: false,
                errorText: "",
            },
            createItemData: {
                openModal: false,
                itemName: "",
                shipmentID: "",
                code: "",
                hasError: false,
                errorText: "",
            },
            updateItemData: {
                openModal: false,
                itemName: "",
                shipmentID: "",
                code: "",
                hasError: false,
                errorText: "",
            }
        },
        methods: {
            tryLogin: function () {
                let data = new FormData;
                data.append('_token', window._token);
                data.append('email', this.loginData.email);
                data.append('password', this.loginData.password);
                fetch('/login', {
                    method: 'POST',
                    body: data
                }).then((resp) => resp.json()).then(function (data) {
                    app.token = data.data[0];
                    app.authorized = true;
                    app.getShipmentList();
                }).catch(function (error) {
                    alert("Login failed");
                });
            },
            getShipmentList: function () {
                let data = new FormData;
                data.append('_token', window._token);
                data.append('token', this.token.token);
                fetch('/shipment_list', {
                    method: 'POST',
                    body: data
                }).then((resp) => resp.json()).then(function (data) {
                    console.log('shipment', data.data.shipments);
                    app.shipments = data.data.shipments;
                }).catch(function (error) {
                    alert("Loading failed");
                });
            },
            startShipmentCreation: function () {
                this.createShipmentData.openModal = true;
            },
            startItemCreation: function (shipment_id) {
                this.createItemData.shipmentID = shipment_id;
                this.createItemData.openModal = true;
            },
            createShipment: function () {
                if (this.createShipmentData.shipmentName == ""){
                    this.createShipmentData.hasError = true;
                    this.createShipmentData.errorText = "Need enter shipment name";
                }
                let data = new FormData;
                data.append('_token', window._token);
                data.append('token', this.token.token);
                data.append('name', this.createShipmentData.shipmentName);
                fetch('/shipment_create', {
                    method: 'POST',
                    body: data
                }).then((resp) => resp.json()).then(function (status) {
                    app.createShipmentData.openModal = false;
                    app.getShipmentList();
                }).catch(function (error) {
                    app.createShipmentData.openModal = false;
                    app.getShipmentList();
                });
            },
            createItem: function () {
                if (this.createItemData.itemName == "" || this.createItemData.code == ""){
                    this.createItemData.hasError = true;
                    this.createItemData.errorText = "Need enter item name or code";
                }
                let data = new FormData;
                data.append('_token', window._token);
                data.append('token', this.token.token);
                data.append('shipment_id', this.createItemData.shipmentID);
                data.append('name', this.createItemData.itemName);
                data.append('code', this.createItemData.code);
                fetch('/item_create', {
                    method: 'POST',
                    body: data
                }).then((resp) => resp.json()).then(function (status) {
                    app.createItemData.openModal = false;
                    app.getShipmentList();
                }).catch(function (error) {
                    app.createShipmentData.openModal = false;
                    app.getShipmentList();
                });
            },
            deleteShipment: function (shipment_id) {
                let data = new FormData;
                data.append('_token', window._token);
                data.append('token', this.token.token);
                data.append('shipment_id', shipment_id);
                fetch('/shipment_delete', {
                    method: 'POST',
                    body: data
                }).then((resp) => resp.json()).then(function () {
                    app.getShipmentList();
                }).catch(function (error) {
                    app.getShipmentList();
                });
            },
            deleteItem: function (item_id) {
                if (this.createItemData.itemName == "" || this.createItemData.code == ""){
                    this.createItemData.hasError = true;
                    this.createItemData.errorText = "Need enter item name or code";
                }
                let data = new FormData;
                data.append('_token', window._token);
                data.append('token', this.token.token);
                data.append('item_id', item_id);
                fetch('/item_delete', {
                    method: 'POST',
                    body: data
                }).then((resp) => resp.json()).then(function (status) {
                    app.createItemData.openModal = false;
                    app.getShipmentList();
                }).catch(function (error) {
                    app.createShipmentData.openModal = false;
                    app.getShipmentList();
                });
            },
            updateItem: function (item) {
                if (this.createItemData.itemName == "" || this.createItemData.code == ""){
                    this.createItemData.hasError = true;
                    this.createItemData.errorText = "Need enter item name or code";
                }
                let data = new FormData;
                data.append('_token', window._token);
                data.append('token', this.token.token);
                data.append('item_id', item_id);
                fetch('/item_delete', {
                    method: 'POST',
                    body: data
                }).then((resp) => resp.json()).then(function (status) {
                    app.createItemData.openModal = false;
                    app.getShipmentList();
                }).catch(function (error) {
                    app.createShipmentData.openModal = false;
                    app.getShipmentList();
                });
            },
            updateShipment: function (shipment) {
                if (this.createItemData.itemName == "" || this.createItemData.code == ""){
                    this.createItemData.hasError = true;
                    this.createItemData.errorText = "Need enter item name or code";
                }
                let data = new FormData;
                data.append('_token', window._token);
                data.append('token', this.token.token);
                data.append('item_id', item_id);
                fetch('/item_delete', {
                    method: 'POST',
                    body: data
                }).then((resp) => resp.json()).then(function (status) {
                    app.createItemData.openModal = false;
                    app.getShipmentList();
                }).catch(function (error) {
                    app.createShipmentData.openModal = false;
                    app.getShipmentList();
                });
            },
        }
    }
)

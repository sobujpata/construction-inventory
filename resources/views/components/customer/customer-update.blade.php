<div class="modal animated zoomIn" id="update-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Update Customer</h5>
            </div>
            <div class="modal-body">
                <form id="update-form">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-6 col-12">
                                <label class="form-label">Subscriber Name *</label>
                                <input type="text" class="form-control" id="customerNameUpdate">
                            </div>
                            <div class="col-md-6 col-12">
                                <label class="form-label">Subscriber Email *</label>
                                <input type="text" class="form-control" id="customerEmailUpdate">
                            </div>
                            <div class="col-md-6 col-12">
                                <label class="form-label">Subscriber Mobile *</label>
                                <input type="text" class="form-control" id="customerMobileUpdate">
                            </div>
                            <div class="col-md-6 col-12">
                                <label class="form-label">Subscriber Division *</label>
                                <select type="text" class="form-control form-select" id="customerDivisionUpdate">
                                    <option value="">Select Division</option>
                                </select>
                            </div>
                            <div class="col-md-6 col-12">
                                <label class="form-label">Subscriber District *</label>
                                <select type="text" class="form-control form-select" id="customerDistrictUpdate">
                                    <option value="">Select District</option>
                                </select>
                            </div>
                            <div class="col-md-6 col-12">
                                <label class="form-label">Subscriber Upazila *</label>
                                <select type="text" class="form-control form-select" id="customerUpazilaUpdate">
                                    <option value="">Select Upazila</option>
                                </select>
                            </div>
                            <div class="col-md-6 col-12">
                                <label class="form-label">Subscriber Union *</label>
                                <select type="text" class="form-control form-select" id="customerUnionUpdate">
                                    <option value="">Select Union</option>
                                </select>
                            </div>
                            <div class="col-md-6 col-12">
                                <label class="form-label">Subscriber Postal Code *</label>
                                <input type="text" class="form-control" id="customerPostalCodeUpdate">
                            </div>
                            <div class="col-md-6 col-12">
                                <label class="form-label">Subscriber Village *</label>
                                <input type="text" class="form-control" id="customerVillageUpdate">
                            </div>
                            <div class="col-md-6 col-12">
                                <label class="form-label">Subscriber Present Address *</label>
                                <input type="text" class="form-control" id="customerPresentAddressUpdate">
                            </div>

                            <div class="col-md-6 col-12">
                                <label class="form-label">Subscriber Profile *</label>
                                <input name="profileUpdate" oninput="oldImg.src=window.URL.createObjectURL(this.files[0])"  type="file" class="form-control" id="profileUpdate">
                            </div>
                            <div class="col-md-6 col-12">
                                <img class="w-15" id="oldImg" src="{{asset('images/default.jpg')}}"/>
                            </div>
                            <input type="text" class="d-none" id="updateID">
                            <input name="filePath" type="text" class="d-none" id="filePath">

                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button id="update-modal-close" class="btn bg-gradient-primary" data-bs-dismiss="modal" aria-label="Close">Close</button>
                <button onclick="Update()" id="update-btn" class="btn bg-gradient-success" >Update</button>
            </div>
        </div>
    </div>
</div>


<script>
    FillDivisionDropDown();

    async function FillDivisionDropDown(){
        let res = await axios.get("/division")
        let resDistrict = await axios.get("/district")
        let resUpazila = await axios.get("/upazila")
        let resUnion = await axios.get("/union")

        res.data.forEach(function (item,i) {
            let option=`<option value="${item['id']}">${item['name']}</option>`
            $("#customerDivisionUpdate").append(option);
        })
        resDistrict.data.forEach(function (item,i) {
            let option=`<option value="${item['id']}">${item['name']}</option>`
            $("#customerDistrictUpdate").append(option);
        })
        resUpazila.data.forEach(function (item,i) {
            let option=`<option value="${item['id']}">${item['name']}</option>`
            $("#customerUpazilaUpdate").append(option);
        })
        resUnion.data.forEach(function (item,i) {
            let option=`<option value="${item['id']}">${item['name']}</option>`
            $("#customerUnionUpdate").append(option);
        })

    }


    async function FillUpUpdateForm(id, filePath){
        document.getElementById('updateID').value=id;
        document.getElementById('filePath').value=filePath;
        document.getElementById('oldImg').src=filePath;

        showLoader();
        let res=await axios.post("/customer-by-id",{id:id})
        // console.log(res);
        hideLoader();
        document.getElementById('customerNameUpdate').value=res.data['name'];
        document.getElementById('customerEmailUpdate').value=res.data['email'];
        document.getElementById('customerMobileUpdate').value=res.data['mobile'];
        document.getElementById('customerDivisionUpdate').value=res.data['division_id'];
        document.getElementById('customerDistrictUpdate').value=res.data['district_id'];
        document.getElementById('customerUpazilaUpdate').value=res.data['upazila_id'];
        document.getElementById('customerUnionUpdate').value=res.data['union_id'];
        document.getElementById('customerPostalCodeUpdate').value=res.data['postal_code'];
        document.getElementById('customerVillageUpdate').value=res.data['village'];
        document.getElementById('customerPresentAddressUpdate').value=res.data['present_address'];
    }


    async function Update() {

        let customerName = document.getElementById('customerNameUpdate').value;
        let customerEmail = document.getElementById('customerEmailUpdate').value;
        let customerMobile = document.getElementById('customerMobileUpdate').value;

        let customerDivision = document.getElementById('customerDivisionUpdate').value;
        let customerDistrict = document.getElementById('customerDistrictUpdate').value;
        let customerUpazila = document.getElementById('customerUpazilaUpdate').value;
        let customerUnion = document.getElementById('customerUnionUpdate').value;
        let customerPostalCode = document.getElementById('customerPostalCodeUpdate').value;
        let customerVillage = document.getElementById('customerVillageUpdate').value;
        let customerPresentAddress = document.getElementById('customerPresentAddressUpdate').value;

        let updateID=document.getElementById('updateID').value;
        let filePath=document.getElementById('filePath').value;
        let profileUpdate = document.getElementById('profileUpdate').files[0];


        if (customerName.length === 0) {
            errorToast("Customer Name Required !")
        }
        else if(customerEmail.length===0){
            errorToast("Customer Email Required !")
        }
        else if(customerMobile.length===0){
            errorToast("Customer Mobile Required !")
        }
        else if(customerDivision.length===0){
            errorToast("Customer Division Required !")
        }
        else if(customerDistrict.length===0){
            errorToast("Customer District Required !")
        }
        else if(customerUpazila.length===0){
            errorToast("Customer Upazila Required !")
        }
        else if(customerUnion.length===0){
            errorToast("Customer Union Required !")
        }
        else if(customerPostalCode.length===0){
            errorToast("Customer PostCode Required !")
        }
        else if(customerVillage.length===0){
            errorToast("Customer Village Required !")
        }
        else if(customerPresentAddress.length===0){
            errorToast("Customer PresentAddress Required !")
        }

        else {

            document.getElementById('update-modal-close').click();

            let formData=new FormData();
            formData.append('id', updateID);
            formData.append('name',customerName)
            formData.append('email',customerEmail)
            formData.append('mobile',customerMobile)
            formData.append('division',customerDivision)
            formData.append('district',customerDistrict)
            formData.append('upazila',customerUpazila)
            formData.append('union',customerUnion)
            formData.append('postalCode',customerPostalCode)
            formData.append('village',customerVillage)
            formData.append('presenstAddress',customerPresentAddress)
            formData.append('file_path', filePath);

            // Adding the image file to FormData
            if (profileUpdate) {
                    formData.append('img', profileUpdate);
                }

            const config = {
                headers: {
                    'content-type': 'multipart/form-data'
                }
            }

            showLoader();

            let res = await axios.post("/update-customer",formData,config)

            hideLoader();

            if(res.status===200){

                successToast('Request completed');

                document.getElementById("update-form").reset();

                await getList();
            }
            else{
                errorToast("Request fail !")
            }
        }
    }

</script>

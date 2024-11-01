<div class="modal animated zoomIn" id="create-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Create Subscribers</h5>
                </div>
                <div class="modal-body">
                    <form id="save-form">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-6 col-12">
                                <label class="form-label">Subscriber Name *</label>
                                <input type="text" class="form-control" id="customerName">
                            </div>
                            <div class="col-md-6 col-12">
                                <label class="form-label">Subscriber Email *</label>
                                <input type="text" class="form-control" id="customerEmail">
                            </div>
                            <div class="col-md-6 col-12">
                                <label class="form-label">Subscriber Mobile *</label>
                                <input type="text" class="form-control" id="customerMobile">
                            </div>
                            <div class="col-md-6 col-12">
                                <label class="form-label">Subscriber Division *</label>
                                <select type="text" class="form-control form-select" id="customerDivision">
                                    <option value="">Select Division</option>
                                </select>
                            </div>
                            <div class="col-md-6 col-12">
                                <label class="form-label">Subscriber District *</label>
                                <select type="text" class="form-control form-select" id="customerDistrict">
                                    <option value="">Select District</option>
                                </select>
                            </div>
                            <div class="col-md-6 col-12">
                                <label class="form-label">Subscriber Upazila *</label>
                                <select type="text" class="form-control form-select" id="customerUpazila">
                                    <option value="">Select Upazila</option>
                                </select>
                            </div>
                            <div class="col-md-6 col-12">
                                <label class="form-label">Subscriber Union *</label>
                                <select type="text" class="form-control form-select" id="customerUnion">
                                    <option value="">Select Union</option>
                                </select>
                            </div>
                            <div class="col-md-6 col-12">
                                <label class="form-label">Subscriber Postal Code *</label>
                                <input type="text" class="form-control" id="customerPostalCode">
                            </div>
                            <div class="col-md-6 col-12">
                                <label class="form-label">Subscriber Village *</label>
                                <input type="text" class="form-control" id="customerVillage">
                            </div>
                            <div class="col-md-6 col-12">
                                <label class="form-label">Subscriber Present Address *</label>
                                <input type="text" class="form-control" id="customerPresentAddress">
                            </div>

                            <div class="col-md-6 col-12">
                                <label class="form-label">Subscriber Profile *</label>
                                <input oninput="newImg.src=window.URL.createObjectURL(this.files[0])" type="file" class="form-control" id="profile">
                            </div>
                            <div class="col-md-6 col-12">
                                <img class="w-15" id="newImg" src="{{asset('images/default.jpg')}}"/>
                            </div>

                        </div>
                    </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button id="modal-close" class="btn bg-gradient-primary" data-bs-dismiss="modal" aria-label="Close">Close</button>
                    <button onclick="Save()" id="save-btn" class="btn bg-gradient-success" >Save</button>
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
            $("#customerDivision").append(option);
        })
        resDistrict.data.forEach(function (item,i) {
            let option=`<option value="${item['id']}">${item['name']}</option>`
            $("#customerDistrict").append(option);
        })
        resUpazila.data.forEach(function (item,i) {
            let option=`<option value="${item['id']}">${item['name']}</option>`
            $("#customerUpazila").append(option);
        })
        resUnion.data.forEach(function (item,i) {
            let option=`<option value="${item['id']}">${item['name']}</option>`
            $("#customerUnion").append(option);
        })

    }

    async function Save() {

        let customerName = document.getElementById('customerName').value;
        let customerEmail = document.getElementById('customerEmail').value;
        let customerMobile = document.getElementById('customerMobile').value;
        let customerDivision = document.getElementById('customerDivision').value;
        let customerDistrict = document.getElementById('customerDistrict').value;
        let customerUpazila = document.getElementById('customerUpazila').value;
        let customerUnion = document.getElementById('customerUnion').value;
        let customerPostalCode = document.getElementById('customerPostalCode').value;
        let customerVillage = document.getElementById('customerVillage').value;
        let customerPresentAddress = document.getElementById('customerPresentAddress').value;
        let profile = document.getElementById('profile').files[0];

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
        else if(!profile){
            errorToast("Subscriber Image Required !")
        }
        else {

            document.getElementById('modal-close').click();

            let formData=new FormData();
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
            formData.append('img',profile)

            const config = {
                headers: {
                    'content-type': 'multipart/form-data'
                }
            }
            showLoader();
            let res = await axios.post("/create-customer",formData,config)
            hideLoader();

            if(res.status===201){
                successToast('Request completed');
                document.getElementById("save-form").reset();
                await getList();
            }
            else{
                errorToast("Request fail !")
            }
        }
    }

</script>

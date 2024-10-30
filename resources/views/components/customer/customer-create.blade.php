<div class="modal animated zoomIn" id="create-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Create Customer</h5>
                </div>
                <div class="modal-body">
                    <form id="save-form">
                    <div class="container">
                        <div class="row">
                            <div class="col-12 p-1">
                                <label class="form-label">Customer Name *</label>
                                <input type="text" class="form-control" id="customerName">
                                <label class="form-label">Customer Email *</label>
                                <input type="text" class="form-control" id="customerEmail">
                                <label class="form-label">Customer Mobile *</label>
                                <input type="text" class="form-control" id="customerMobile">
                                <label class="form-label">Customer Division *</label>
                                <input type="text" class="form-control" id="customerDivision">
                                <label class="form-label">Customer District *</label>
                                <input type="text" class="form-control" id="customerDistrict">
                                <label class="form-label">Customer Upazila *</label>
                                <input type="text" class="form-control" id="customerUpazila">
                                <label class="form-label">Customer Union *</label>
                                <input type="text" class="form-control" id="customerUnion">
                                <label class="form-label">Customer Postal Code *</label>
                                <input type="text" class="form-control" id="customerPostaCode">
                                <label class="form-label">Customer Village *</label>
                                <input type="text" class="form-control" id="customerVillage">
                                <label class="form-label">Customer Present Address *</label>
                                <input type="text" class="form-control" id="customerPresentAddress">
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
        else if(customerPostCode.length===0){
            errorToast("Customer PostCode Required !")
        }
        else if(customerVillage.length===0){
            errorToast("Customer Village Required !")
        }
        else if(customerPresentAddress.length===0){
            errorToast("Customer PresentAddress Required !")
        }
        else {

            document.getElementById('modal-close').click();

            showLoader();
            let res = await axios.post("/create-customer",{
                name:customerName,
                email:customerEmail,
                mobile:customerMobile,
                division:customerDivision,
                district:customerDistrict,
                upazila:customerUpazila,
                union:customerUnion,
                postalCode:customerPostCode,
                village:customerVillage,
                presenstAddress:customerPresentAddress })
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

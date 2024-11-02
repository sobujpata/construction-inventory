
<div class="modal animated zoomIn" id="update-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Update Item Qty</h5>
            </div>
            <div class="modal-body">
                <form id="update-form">
                    <div class="container">
                        <div class="row">
                            <div class="col-12 p-1">
                                <label class="form-label">Customer Name</label>
                                <input type="text" id="castomerName" name="castomerName" class="form-control" readonly>

                                <label class="form-label mt-2">Due Amount</label>
                                <input type="number" class="form-control" id="dueAmount" readonly>

                                <label class="form-label mt-2">Payment Due</label>
                                <input type="number" class="form-control" id="paymentDue">

                                <input type="number" class="d-none" id="mainAmount">

                                <input type="text" class="d-none" id="updateID">
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <div class="modal-footer">
                <button id="update-modal-close" class="btn bg-gradient-primary" data-bs-dismiss="modal" aria-label="Close">Close</button>
                <button onclick="update()" type="submit" id="update-btn" class="btn bg-gradient-success" >Update</button>
            </div>

        </div>
    </div>
</div>


<script>



    async function FillUpUpdateForm(id){

        document.getElementById('updateID').value=id;



        showLoader();
        let res=await axios.post("/collection-by-id",{id:id})
        hideLoader();
        console.log(res);
        document.getElementById('castomerName').value=res.data.data['customer']['name'];
        document.getElementById('dueAmount').value=res.data.data['due'];
        document.getElementById('mainAmount').value=res.data.data['amount'];
        }


    async function update() {
    let dueAmount = document.getElementById('dueAmount').value;
    let paymentDue = document.getElementById('paymentDue').value;
    let mainAmount = document.getElementById('mainAmount').value;
    let updateID = document.getElementById('updateID').value;


    // Validation
    if (dueAmount.length === 0) {
        errorToast("Product Due Amount Required !");
        return;
    } else if (paymentDue.length === 0) {
        errorToast("Product Payment Amount Required !");
        return;
    }

    else {
        document.getElementById('update-modal-close').click(); // Close modal if form is valid

        let formData = new FormData();
        formData.append('dueAmount', dueAmount);
        formData.append('paymentDue', paymentDue);
        formData.append('mainAmount', mainAmount);
        formData.append('id', updateID);



        const config = {
            headers: {
                'content-type': 'multipart/form-data'
            }
        };

        try {
            showLoader();
            let res = await axios.post(`/collection-update/${updateID}`, formData, config);
            hideLoader();

            if (res.status === 200) {
                successToast('Request completed');
                document.getElementById("update-form").reset();
                await getList();
            } else {
                errorToast("Request failed!");
            }
        } catch (error) {
            hideLoader();
            if (error.response) {
                console.error("Validation errors:", error.response.data.errors);
                console.error("Full Response:", error.response.data); // Log full response for more details
                if (error.response.status === 422) {
                    let validationErrors = error.response.data.errors;
                    for (const key in validationErrors) {
                        if (validationErrors.hasOwnProperty(key)) {
                            errorToast(validationErrors[key][0]);
                        }
                    }
                } else {
                    errorToast("An error occurred while processing the request.");
                }
            }
        }
    }
}



</script>

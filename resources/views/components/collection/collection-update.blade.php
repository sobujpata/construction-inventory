
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
                                <input type="text" id="productCategoryUpdate" name="categoryName" class="form-control" readonly>
                                
                                <label class="form-label mt-2">Item Use Old</label>
                                <input type="number" class="form-control" id="usesQtyUpdate" readonly>

                                <label class="form-label mt-2">Item Use</label>
                                <input type="number" class="form-control" id="usesQtyUpdateNew">

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
        // await UpdateFillCategoryDropDown();

        let res=await axios.post("/store-item-by-id",{id:id})
        hideLoader();

        document.getElementById('productCategoryUpdate').value=res.data.data['category_id'];
        document.getElementById('productCategoryUpdate').value=res.data.data['category']['categoryName'];


        document.getElementById('usesQtyUpdate').value=res.data.data['uses_qty'];

        }


    async function update() {
    let usesQtyUpdate = document.getElementById('usesQtyUpdate').value;
    let usesQtyUpdateNew = document.getElementById('usesQtyUpdateNew').value;
    let productCategoryUpdate = document.getElementById('productCategoryUpdate').value;
    let updateID = document.getElementById('updateID').value;


    // Validation
    if (productCategoryUpdate.length === 0) {
        errorToast("Product Category Required !");
        return;
    } else if (usesQtyUpdate.length === 0) {
        errorToast("Product Cost Required !");
        return;
    }

    else {
        document.getElementById('update-modal-close').click(); // Close modal if form is valid

        let formData = new FormData();
        formData.append('category_id', parseInt(productCategoryUpdate));
        formData.append('uses_qty', usesQtyUpdate);
        formData.append('uses_qty_new', usesQtyUpdateNew);
        formData.append('id', updateID);



        const config = {
            headers: {
                'content-type': 'multipart/form-data'
            }
        };

        try {
            showLoader();
            let res = await axios.post(`/store-update/${updateID}`, formData, config);
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

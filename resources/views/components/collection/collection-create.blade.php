<div class="modal animated zoomIn" id="create-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Create Collection</h5>
                </div>
                <div class="modal-body">
                    <form id="save-form">
                    <div class="container">
                        <div class="row">
                            <div class="col-12 p-1">
                                <label class="form-label"> Customer Name</label>
                                <select type="text" class="form-control form-select" id="customerName">
                                    <option value="">Select customer</option>
                                </select>
                                <label for="amount">Amount</label>
                                <input type="number" class="form-control" id="amount" placeholder="Enter amount">
                                <label for="due">Due Amount</label>
                                <input type="number" class="form-control" id="due" placeholder="Enter due">
                            </div>
                        </div>
                    </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button id="modal-close" class="btn bg-gradient-primary mx-2" data-bs-dismiss="modal" aria-label="Close">Close</button>
                    <button onclick="Save()" id="save-btn" class="btn bg-gradient-success" >Save</button>
                </div>
            </div>
    </div>
</div>


<script>

FillCategoryDropDown()
async function FillCategoryDropDown() {
    try {
        let res = await axios.get("/list-customer");
        console.log(res);

        // Clear existing options to avoid duplicates
        $("#customerName").empty();
        $("#customerName").append('<option value="">Select Customer</option>'); // Optional placeholder option

        res.data.forEach(function (item, i) {
            let option = `<option value="${item['id']}">${item['name']}</option>`;
            $("#customerName").append(option);
        });
    } catch (error) {
        console.error("Error fetching categories:", error);
        errorToast("Failed to load categories. Please try again.");
    }
}



    async function Save() {
    let customerName = document.getElementById('customerName').value;
    let amount = document.getElementById('amount').value;
    let due = document.getElementById('due').value;

    if (customerName.length === 0) {
        errorToast("Product Name Required!");
        return;
    }

    document.getElementById('modal-close').click();
    let formData = new FormData();
    formData.append('customer_id', customerName);
    formData.append('amount', amount);
    formData.append('due', due);

    const config = {
        headers: {
            'content-type': 'multipart/form-data'
        }
    };

    try {
        showLoader();
        let res = await axios.post("/collection-create", formData, config);
        hideLoader();

        if (res.status === 201) {
            successToast('Request completed');
            document.getElementById("save-form").reset();
            await getList();
        }
    } catch (error) {
        hideLoader();
        
        // Check if the error is a 409 Conflict (duplicate category_id)
        if (error.response && error.response.status === 409) {
            errorToast("A store with this Item Name already exists!");
        } else {
            errorToast("Request failed!");
        }
    }
}

</script>

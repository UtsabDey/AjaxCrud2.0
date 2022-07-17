{{-- <div class="modal fade editCountry" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"
    data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Country</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="<?= url('update.country.details') ?>" method="post" id="update-country-form">
                    @csrf
                    <input type="hidden" name="cid">
                    <div class="form-group">
                        <label for="">Country name</label>
                        <input type="text" class="form-control" name="country_name" placeholder="Enter country name">
                        <span class="text-danger error-text country_name_error"></span>
                    </div>
                    <div class="form-group">
                        <label for="">Capital city</label>
                        <input type="text" class="form-control" name="capital_city" placeholder="Enter capital city">
                        <span class="text-danger error-text capital_city_error"></span>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-sm btn-success">Save Changes</button>
                    </div>
                </form>


            </div>
        </div>
    </div>
</div> --}}


<div class="modal fade editCountry" id="exampleModal" role="dialog" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Country</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ url('updatecountryDetails') }}" method="POST" id="update-country-form">
                    @csrf
                    <div class="mb-3">
                    <input type="hidden" name="cid">
                        <label for="" class="col-form-label">Country name</label>
                        <input type="text" class="form-control" name="country_name" id="country_name" placeholder="Enter country name" required>
                        <span class="text-danger country_name_error"></span>
                    </div>
                    <div class="mb-3">
                        <label for="" class="col-form-label">Capital city</label>
                        <input type="text" class="form-control" name="capital_city" placeholder="Enter capital city" required>
                        <span class="text-danger error-text capital_city_error"></span>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success">Update</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>

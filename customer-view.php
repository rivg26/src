<?php require_once 'head.php' ?>
<div class="container">

    <div class="row shadow p-5 mb-4 bg-body rounded  mt-3">
        <div class="text-center">
            <h5 class="display-4 mb-5 mt-3">Add Customer</h5>
        </div>
        <fieldset class="border mt-5 p-5  g-5 bg-light">
            <legend class="float-none w-auto">Personal Information</legend>
            <div class="row">
                <div class="col-md-5 mb-3">
                    <label for="exampleInputEmail1" class="form-label">First Name</label>
                    <input type="text" class="form-control shadow-none" id="exampleInputEmail1" aria-describedby="emailHelp">
                </div>
                <div class="col-md-5 mb-3">
                    <label for="exampleInputEmail1" class="form-label">Last Name</label>
                    <input type="text" class="form-control shadow-none" id="exampleInputEmail1" aria-describedby="emailHelp">
                </div>
                <div class="col-md-2 mb-3">
                    <label for="exampleInputEmail1" class="form-label">Middle Initial</label>
                    <input type="text" class="form-control shadow-none" id="exampleInputEmail1" aria-describedby="emailHelp">
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-3">
                    <label for="exampleInputEmail1" class="form-label">Phone Number</label>
                    <input type="text" class="form-control shadow-none" id="exampleInputEmail1" maxlength="11" aria-describedby="emailHelp">
                </div>
            </div>
        </fieldset>
        <fieldset class="border mt-5 p-5  g-5 bg-light">
            <legend class="float-none w-auto">Address</legend>
            <div class="row mb-3">
                <div class="col-md-6 mb-3">
                    <label for="exampleInputEmail1" class="form-label">House/Unit No.*</label>
                    <input type="text" class="form-control shadow-none" id="exampleInputEmail1" placeholder="house/unit no.">
                </div>
                <div class="col-md-6 mb-3">
                    <label for="exampleInputEmail1" class="form-label">Street/Bldg.*</label>
                    <input type="text" class="form-control shadow-none" id="exampleInputEmail1" placeholder="street bldg.">
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-3 mb-3">
                    <label for="region" class="form-label">Region*</label>
                    <select class="form-select shadow-none" id="region" name="region"></select>
                    <div class="valid-feedback">
                        Looks good!
                    </div>
                    <div id="regionInvalidFeedback" class="invalid-feedback">
                        Please Select Region...
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <label for="exampleInputEmail1" class="form-label">Province*</label>
                    <select class="form-select shadow-none" id="province" name="province"></select>

                </div>
                <div class="col-md-3 mb-3">
                    <label for="exampleInputEmail1" class="form-label">Municipality/City*</label>
                    <select class="form-select shadow-none" id="city" name="city" ></select>

                </div>
                <div class="col-md-3 mb-3">
                    <label for="exampleInputEmail1" class="form-label">Barangay*</label>
                    <select class="form-select shadow-none" id="barangay" name="barangay"></select>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <label for="floatingTextarea2" class="form-label">Landmark</label>
                    <textarea class="form-control shadow-none" placeholder="Leave a comment here" id="floatingTextarea2" style="height: 100px"></textarea>
                </div>
            </div>
        </fieldset>
    </div>
    <input type="hidden" id="hiddenProvince"></input>
    <input type="hidden" id="hiddenCity"></input>
    <input type="hidden" id="hiddenBarangay"></input>
</div>
<?php require_once 'footer.php' ?>
<script src="https://f001.backblazeb2.com/file/buonzz-assets/jquery.ph-locations-v1.0.0.js"></script>
<script>
    $(document).ready(function() {

        var my_handlers = {

            fill_provinces: function() {

                var region_code = $(this).val();
                $('#province').ph_locations('fetch_list', [{
                    "region_code": region_code

                }]);

            },

            fill_cities: function() {

                var province_code = $(this).val();
                $('#city').ph_locations('fetch_list', [{
                    "province_code": province_code
                }]);
                let selected_caption = $("#province option:selected").text();

                // the hidden field will contain the name of the region, not the code
                $('#hiddenProvince').val(selected_caption);

            },


            fill_barangays: function() {

                var city_code = $(this).val();
                $('#barangay').ph_locations('fetch_list', [{
                    "city_code": city_code
                }]);

                let selected_caption = $("#city option:selected").text();
                $('#hiddenCity').val(selected_caption)
            }
        };

        $(function() {
            $('#region').on('change', my_handlers.fill_provinces);
            $('#province').on('change', my_handlers.fill_cities);
            $('#city').on('change', my_handlers.fill_barangays);

            $('#region').ph_locations({
                'location_type': 'regions'
            });
            $('#province').ph_locations({
                'location_type': 'provinces'
            });
            $('#city').ph_locations({
                'location_type': 'cities'
            });
            $('#barangay').ph_locations({
                'location_type': 'barangays'
            });

            $('#region').ph_locations('fetch_list');
        });

        $(function() {

            $('#barangay').on('change', function() {

                // we are getting the text() here, not val()
                var selected_caption = $("#barangay option:selected").text();

                // the hidden field will contain the name of the region, not the code
                $('#hiddenBarangay').val(selected_caption);

            }).ph_locations('fetch_list');

        });

        // $(document).on('change','#region',function(){
        //     alert($('#region').val())
        // });
    });
</script>
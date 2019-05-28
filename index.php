
<html>
<head>
	<title>API Test</title>
	<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css"/>
	<script src="bootstrap/js/bootstrap.bundle.min.js"></script>
</head>
<body>
<!--<button type="button" onclick="lookup_upc(0076031150489);">Lookup</button>
<div id="result" style="width:80%;"></div>-->
<body>
    <div>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h1 class="text-center bg-light shadow" style="margin: 8px;padding: 10px;">Product Detail Form</h1>
                </div>
            </div>
        </div>
    </div>
    <div>
        <div class="container">
            <div class="row">
                <div class="col-md-12"><br></div>
            </div>
        </div>
    </div>
    <div>
        <div class="container">
            <div class="row">
                <div class="col-md-12"><input class="border rounded border-dark form-control-lg" type="text" style="width: 100%;margin: 2px;" placeholder="Scan UPC Code Here" name="UPC Code Scan"></div>
            </div>
        </div>
    </div><br>
    <div style="padding: 15px;">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h4 class="text-left">Title:</h4>
                </div>
                <div class="col"><input type="text" id="product_title" style="width: 100%;" name="product_title"></div>
            </div>
        </div>
    </div>
    <div style="padding: 15px;">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h4 class="text-left">Custom Label:</h4>
                </div>
                <div class="col-md-6"><input type="text" id="product_label" style="width: 100%;" name="product_label"></div>
            </div>
        </div>
    </div>
    <div style="padding: 15px;">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h4 class="text-left">Category:</h4>
                </div>
                <div class="col-md-6"><input type="text" id="product_category" style="width: 100%;" name="product_category"></div>
            </div>
        </div>
    </div>
    <div style="padding: 15px;">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h4 class="text-left">UPC Code:</h4>
                </div>
                <div class="col-md-6"><input type="text" id="product_code" style="width: 100%;" name="product_code"></div>
            </div>
        </div>
    </div>
    <div style="padding: 15px;">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h4 class="text-left">Condition:</h4>
                </div>
                <div class="col-md-6"><input type="text" id="product_title" style="width: 100%;" name="product_title"></div>
            </div>
        </div>
    </div>
    <div style="padding: 15px;">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h4 class="text-left">Images:</h4>
                    <div class="text-left"><button class="btn btn-primary text-center text-body bg-light border rounded border-dark shadow-sm" type="button">Upload</button></div>
                </div>
                <div class="col-md-6"><img id="product_image1" name="product_image1" style="width: 33%;"><img id="product_image2" name="product_image2" style="width: 33%;"><img id="product_image3" name="product_image3" style="width: 33%;"></div>
            </div>
        </div>
    </div>
    <div style="padding: 15px;">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h4 class="text-left">Price:</h4>
                </div>
                <div class="col-md-6"><input type="text" id="product_price" style="width: 100%;" name="product_price"></div>
            </div>
        </div>
    </div>
    <div style="padding: 15px;">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h4 class="text-left">Quantity:</h4>
                </div>
                <div class="col-md-6"><input type="text" id="product_quantity" style="width: 100%;" name="product_quantity"></div>
            </div>
        </div>
    </div><br>
    <div class="text-center">
        <div class="btn-group" role="group" style="margin: 0px;padding: 10px;"><button class="btn btn-light btn-lg border rounded-0 shadow-sm" type="button">Cancel</button><button class="btn btn-dark btn-lg text-white border rounded-0 border-dark shadow-sm" type="submit">Submit</button></div>
    </div><br>
</body>
<script src="assets/js/digit-eyes-api.js"></script>
</html>


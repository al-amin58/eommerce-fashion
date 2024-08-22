<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Invoice</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style type="text/css" media="print">
        @page {
            size: auto;
            margin: 0;
        }
        * {
            visibility: hidden;
        }
        #invoice, #invoice * {
            visibility: visible;
        }
        #invoice {
            position: absolute;
            left: 0;
            top: 0;
        }
    </style>
</head>
<body>
<div class="container" id="invoice">
    <div class="row">
        <div class="col-md-6">
            <h3>Invoice</h3>
        </div>
        <div class="col-md-6 text-right">
            <p>Date: 1/1/2022</p>
            <p>Invoice #: 123456</p>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <h4>From:</h4>
            <p>John Doe</p>
            <p>123 Main St</p>
            <p>Anytown, USA 12345</p>
        </div>
        <div class="col-md-6 text-right">
            <h4>To:</h4>
            <p>Jane Smith</p>
            <p>456 Oak Ave</p>
            <p>Anytown, USA 12345</p>
        </div>
    </div>
    <div class="row mt-4">
        <div class="col-md-12">
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>Description</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Total</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>Item 1</td>
                    <td>2</td>
                    <td>$10.00</td>
                    <td>$20.00</td>
                </tr>
                <tr>
                    <td>Item 2</td>
                    <td>1</td>
                    <td>$20.00</td>
                    <td>$20.00</td>
                </tr>
                <tr>
                    <td colspan="3">Subtotal</td>
                    <td>$40.00</td>
                </tr>
                <tr>
                    <td colspan="3">Tax</td>
                    <td>$4.00</td>
                </tr>
                <tr>
                    <td colspan="3">Total</td>
                    <td>$44.00</td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="text-center mt-5">
    <button class="btn btn-primary" onclick="window.print()">Print</button>
</div>
</body>
</html>

function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            myFunction(e.target.result);
        }
        reader.readAsDataURL(input.files[0])
    }
}

$(function () {
    $('#proformaExcelFileInput').on('change', function () {
        readURL(this);
        URL = "/excel";
    });
    $('#deliveryExcelFileInput').on('change', function () {
        readURL(this);
        URL = "/deliveries";
    })
});

function myFunction(filePath) {

    /* set up XMLHttpRequest */
    var url = filePath;//"Test.xlsx";
    var oReq = new XMLHttpRequest();
    oReq.open("GET", url, true);
    oReq.responseType = "arraybuffer";

    oReq.onload = function (e) {
        var arraybuffer = oReq.response;

        /* convert data to binary string */
        var data = new Uint8Array(arraybuffer);
        var arr = new Array();
        for (var i = 0; i != data.length; ++i) arr[i] = String.fromCharCode(data[i]);
        var bstr = arr.join("");

        /* Call XLSX */
        var workbook = XLSX.read(bstr, {type: "binary"});

        /* DO SOMETHING WITH workbook HERE */
        var first_sheet_name = workbook.SheetNames[0];
        /* Get worksheet */
        var worksheet = workbook.Sheets[first_sheet_name];

        var test = XLSX.utils.sheet_to_json(worksheet, {raw: true})
        prepareData(test)
    }
    oReq.send();
}

function prepareData(stylesheet) {
    orders = [];

    var info = {};
    var delivery_date = stylesheet[3].__EMPTY_5.replace("Date", "").replace("date", "").trim();
    info['delivery date'] = delivery_date;
    var delivery_date_eth = stylesheet[2].__EMPTY_5.replace("Date", "").replace("date", "").trim();
    info['delivery date eth'] = delivery_date_eth;
    var company = stylesheet[6][Object.keys(stylesheet[6])[0]].replace("To", "").replace("to", "").replace("-", "").trim();
    info['company'] = company;
    var fs = stylesheet[6].__EMPTY_5.replace("Fs", "").replace("fs", "").replace("no", "").replace("No", "").trim();
    info['fs'] = fs;

    note = "";

    final_object = {};
    final_object["info"] = info;

    var current_package_orders = [];
    var package = {};

    for (var i = 0; i < stylesheet.length; i++) {


        //if 2nd column is length start new package
        if (stylesheet[i].__EMPTY === "Length" || stylesheet[i].__EMPTY === "Lengeth") {
            if (current_package_orders.length > 0) {
                package['data'] = current_package_orders;
                orders.push(package);
            }
            current_package_orders = [];
            package = {};
            package["name"] = stylesheet[i][Object.keys(stylesheet[i])[0]];

        } else if (typeof(stylesheet[i][Object.keys(stylesheet[i])[0]]) === "number") {
            //if number then start current package orders
            var order_entry = [];
            order_entry.push(stylesheet[i][Object.keys(stylesheet[i])[0]]);
            order_entry.push(stylesheet[i].__EMPTY);
            order_entry.push(stylesheet[i].__EMPTY_1);
            order_entry.push(stylesheet[i].__EMPTY_2);
            order_entry.push(stylesheet[i].__EMPTY_3);
            if (typeof(stylesheet[i].__EMPTY_8) !== "undefined") {
                order_entry.push(stylesheet[i].__EMPTY_8);
            } else {
                order_entry.push("");
            }
            current_package_orders.push(order_entry);
        } else if (typeof(stylesheet[i][Object.keys(stylesheet[i])[0]]) === "string") {
            if (typeof stylesheet[i].__EMPTY_6 !== "undefined") {
                if (typeof stylesheet[i].__EMPTY_6 === "number") {
                    package[stylesheet[i][Object.keys(stylesheet[i])[0]]] = stylesheet[i].__EMPTY_6;
                }
            } else {
                if (i > 8 && typeof(stylesheet[i].__EMPTY_6) !== "number" && typeof(stylesheet[i].__EMPTY_7) !== "number" && typeof(stylesheet[i].__EMPTY_4) !== "number") {
                    note += "\n " + stylesheet[i][Object.keys(stylesheet[i])[0]];
                }
            }
        }

    }

    package['data'] = current_package_orders;
    orders.push(package);

    //add the last order
    // orders.push(current_order);
    final_object["note"] = note;
    final_object["orders"] = orders;
    // current_order['data'] = current_package_data;
    console.log(final_object);
    displayTable(orders);
}

function sendData(data) {
    $ajax({
        'url': '',
        'method': 'POST',
        'dataType': 'json',
        processData: false,
        'contentType': 'application/json',
        'data': data,

    })
}

function displayTable(packages) {
    // alert('test')
    total_amount_of_all = 0;
    for (var i = 0; i < packages.length; i++) {
        var shouldAppend = getHeader(packages[i].name);
        $('#myTable > tbody:last-child').append(shouldAppend);
        $('#myTable tr:last').after(getDatas(packages[i]));
        $("#sendToSystem").removeClass("invisible");
    }
    $('#myTable tr:last').after(getFooter());
}

function getFooter() {
    //total_amount_of_all
    var total = total_amount_of_all + (total_amount_of_all * 0.1);
    var footer = '' +
        '  <tr class="bg-dark text-white">' +
        '    <th scope="col"></th>' +
        '    <th scope="col"></th>' +
        '    <th scope="col"></th>' +
        '    <th scope="col"></th>' +
        '    <th scope="col"></th>' +
        '    <th scope="col"></th>' +
        '    <th scope="col"></th>' +
        '    <th scope="col">Amount</th>' +
        '    <th scope="col">' + total_amount_of_all + '</th>' +
        '    <th scope="col"></th>' +
        '  </tr>' +
        '  <tr class="bg-dark text-white">' +
        '    <th scope="col"></th>' +
        '    <th scope="col"></th>' +
        '    <th scope="col"></th>' +
        '    <th scope="col"></th>' +
        '    <th scope="col"></th>' +
        '    <th scope="col"></th>' +
        '    <th scope="col"></th>' +
        '    <th scope="col">Vat</th>' +
        '    <th scope="col">' + (total_amount_of_all * 0.1).toFixed(2) + '</th>' +
        '    <th scope="col"></th>' +
        '  </tr>' +
        '  <tr class="bg-dark text-white">' +
        '    <th scope="col"></th>' +
        '    <th scope="col"></th>' +
        '    <th scope="col"></th>' +
        '    <th scope="col"></th>' +
        '    <th scope="col"></th>' +
        '    <th scope="col"></th>' +
        '    <th scope="col"></th>' +
        '    <th scope="col">Total </th>' +
        '    <th scope="col">' + total.toFixed(2) + '</th>' +
        '    <th scope="col"></th>' +
        '  </tr>' +

        '';
    return footer;
}

function getHeader(name) {
    var header = '<thead>' +
        '  <tr class="bg-light">' +
        '    <th scope="col">' + name + '</th>' +
        '    <th scope="col">Length</th>' +
        '    <th scope="col">Width</th>' +
        '    <th scope="col">Thick</th>' +
        '    <th scope="col">Pcs</th>' +
        '    <th scope="col">Ml</th>' +
        '    <th scope="col">M2</th>' +
        '    <th scope="col">Unit price</th>' +
        '    <th scope="col">Amount</th>' +
        '    <th scope="col">Remark</th>' +
        '  </tr>' +
        '</thead>';
    return header;
}

function getDatas(package) {
    package_data = package.data;

    var m1 = 0;
    var m2 = 0;
    var table = '';
    var total_amount = 0;
    for (var i = 0; i < package_data.length; i++) {
        package_data[i]
        var str = package_data[i][5];//.toLowerCase();
        //var list=str.split("&");
        if (str != "") {
            m1 += package_data[i][1] * package_data[i][4];
        }

        m2 += package_data[i][1] * package_data[i][2] * package_data[i][4]

        table +=
            '<tr>' +
            '  <th scope="row">' + package_data[i][0] + '</th>' +
            '  <td>' + package_data[i][1] + '</td>' +
            '  <td>' + package_data[i][2] + '</td>' +
            '  <td>' + package_data[i][3] + '</td>' +
            '  <td>' + package_data[i][4] + '</td>' +
            '  <td>' + (package_data[i][1] * package_data[i][4]).toFixed(2) + '</td>' +
            '  <td>' + (package_data[i][1] * package_data[i][2] * package_data[i][4]).toFixed(2) + '</td>' +
            '  <td></td>' +
            '  <td></td>' +
            '  <td>' + package_data[i][5] + '</td>' +
            '</tr>';
    }

    if (package.hasOwnProperty('Bullnose')) {
        total_amount += m1 * package.Bullnose
        table += getAdditional('Bullnose', m1, package.Bullnose);
    }
    if (package.hasOwnProperty('bullnose')) {
        total_amount += m1 * package.bullnose
        table += getAdditional('bullnose', m1, package.bullnose);
    }
    if (package.hasOwnProperty('Groove')) {
        total_amount += m1 * package.Groove
        table += getAdditional('Groove', m1, package.Groove);
    }
    if (package.hasOwnProperty('groove')) {
        total_amount += m1 * package.groove
        table += getAdditional('groove', m1, package.groove);
    }

    if (package.hasOwnProperty('unit_price')) {
        m2price = package.unit_price
    } else if (package.hasOwnProperty('m2')) {
        m2price = package.m2
    } else if (package.hasOwnProperty('M2')) {
        m2price = package.M2
    }
    var amount = m2.toFixed(2) * m2price.toFixed(2);
    total_amount += amount;
    total_amount_of_all += total_amount;
    table +=
        'tr>' +
        '  <th scope="row">M2</th>' +
        '  <td></td>' +
        '  <td></td>' +
        '  <td></td>' +
        '  <td></td>' +
        '  <td></td>' +
        '  <td>' + m2.toFixed(2) + '</td>' +
        '  <td>' + m2price.toFixed(2) + '</td>' +
        '  <td>' + amount.toFixed(2) + '</td>' +
        '  <td></td>' +
        '</tr>';


    table += '<tr class="">' +
        '<th scope="row">Subtotal</th>' +
        '<td></td>' +
        '<td></td>' +
        '<td></td>' +
        '<td></td>' +
        '<td></td>' +
        '<td></td>' +
        '<td></td>' +
        '<td>' + total_amount.toFixed(2) + '</td>' +
        '<td></td>' +
        '</tr>'

    return table;

}

function getAdditional(name, ml, unitprice) {
    var d = '<tr>' +
        '  <th scope="row">' + name + '</th>' +
        '  <td></td>' +
        '  <td></td>' +
        '  <td></td>' +
        '  <td></td>' +
        '  <td>' + ml.toFixed(2) + '</td>' +
        '  <td></td>' +
        '  <td>';
        if(unitprice) {
            d += unitprice.toFixed(2);
        }
        d += '</td>' +
        '  <td>' + (ml * unitprice).toFixed(2) + '</td>' +
        '  <td></td>' +
        '</tr>'
    return d;
}